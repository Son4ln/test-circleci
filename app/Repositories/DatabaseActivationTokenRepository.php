<?php

namespace App\Repositories;

use Carbon\Carbon;
use Illuminate\Contracts\Hashing\Hasher;
use Illuminate\Database\ConnectionInterface;
use Illuminate\Support\Str;

class DatabaseActivationTokenRepository implements ActivationTokenRepository
{
    /**
     * The database connection instance.
     *
     * @var \Illuminate\Database\ConnectionInterface
     */
    protected $connection;

    /**
     * The Hasher implementation.
     *
     * @var \Illuminate\Contracts\Hashing\Hasher
     */
    protected $hasher;

    /**
     * The email token database table.
     *
     * @var string
     */
    protected $table;

    /**
     * The hashing key.
     *
     * @var string
     */
    protected $hashKey;

    /**
     * The number of seconds a token should last.
     *
     * @var int
     */
    protected $expires;

    /**
     * Create a new token repository instance.
     *
     * @param  \Illuminate\Database\ConnectionInterface  $connection
     * @param  \Illuminate\Contracts\Hashing\Hasher  $hasher
     * @param  string  $table
     * @param  string  $hashKey
     * @param  int  $expires The minutes
     */
    public function __construct(
        ConnectionInterface $connection,
        Hasher $hasher,
        string $table,
        string $hashKey,
        int $expires = 120
    ) {

        $this->table = $table;
        $this->hasher = $hasher;
        $this->hashKey = $hashKey;
        $this->expires = $expires * 60;
        $this->connection = $connection;
    }

    /**
     * Create a new token.
     *
     * @param  string $email
     * @return string
     */
    public function create($email)
    {
        $this->deleteExisting($email);

        // We will create a new, random token for the model so that we can e-mail them
        // a safe link to the email update form. Then we will insert a record in
        // the database so that we can verify the token within the actual update.
        $token = $this->createNewToken();

        $this->getTable()->insert($this->getPayload($email, $token));

        return $token;
    }

    /**
     * Determine if a token record exists and is valid.
     *
     * @param  string $email
     * @param  string $token
     * @return bool|array
     */
    public function exists($email, $token)
    {
        $record = (array) $this->getTable()
            ->where('email', $email)
            ->first();

        if ($record &&
            !$this->tokenExpired($record['created_at']) &&
            $this->getHasher()->check($token, $record['token'])
        ) {
            return $record;
        }

        return false;
    }

    /**
     * Delete a token record.
     *
     * @param  string $email
     * @return void
     */
    public function delete($email)
    {
        $this->deleteExisting($email);
    }

    /**
     * Delete expired tokens.
     *
     * @return void
     */
    public function deleteExpired()
    {
        $expiredAt = Carbon::now()->subSeconds($this->expires);

        $this->getTable()->where('created_at', '<', $expiredAt)->delete();
    }

    /**
     * Delete all existing reset tokens from the database.
     *
     * @param  string $email
     * @return int
     */
    protected function deleteExisting($email)
    {
        return $this->getTable()
            ->where('email', $email)
            ->delete();
    }

    /**
     * Get the database connection instance.
     *
     * @return \Illuminate\Database\ConnectionInterface
     */
    public function getConnection()
    {
        return $this->connection;
    }

    /**
     * Begin a new database query against the table.
     *
     * @return \Illuminate\Database\Query\Builder
     */
    public function getTable()
    {
        return $this->connection->table($this->table);
    }

    /**
     * Get the hasher instance.
     *
     * @return \Illuminate\Contracts\Hashing\Hasher
     */
    public function getHasher()
    {
        return $this->hasher;
    }

    /**
     * Create a new token.
     *
     * @return string
     */
    public function createNewToken()
    {
        return hash_hmac('sha256', Str::random(40), $this->hashKey);
    }

    /**
     * Build the record payload for the table.
     *
     * @param  string $email
     * @param  string $token
     * @return array
     */
    protected function getPayload($email, $token)
    {
        return [
            'email' => $email,
            'token' => $this->getHasher()->make($token),
            'created_at' => new Carbon(),
        ];
    }

    /**
     * Determine if the token has expired.
     *
     * @param  string  $createdAt
     * @return bool
     */
    protected function tokenExpired($createdAt)
    {
        return Carbon::parse($createdAt)->addSeconds($this->expires)->isPast();
    }
}
