<?php

namespace App\Repositories;

interface ActivationTokenRepository
{
    /**
     * Create a new token.
     *
     * @param  string   $email
     * @return string
     */
    public function create($email);

    /**
     * Determine if a token record exists and is valid.
     *
     * @param  string $email
     * @param  string $token
     * @return bool|array
     */
    public function exists($email, $token);

    /**
     * Delete a token record.
     *
     * @param  string $email
     * @return void
     */
    public function delete($email);

    /**
     * Delete expired tokens.
     *
     * @return void
     */
    public function deleteExpired();
}
