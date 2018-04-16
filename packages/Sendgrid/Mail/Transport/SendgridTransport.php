<?php

namespace Rabiloo\Sendgrid\Mail\Transport;

use Illuminate\Mail\Transport\Transport;
use Swift_Attachment;
use Swift_Image;
use Swift_Mime_Message;
use Swift_MimePart;
use GuzzleHttp\ClientInterface;

class SendgridTransport extends Transport
{
    const API_ENDPOINT = 'https://api.sendgrid.com/v3/mail/send';
    const MAXIMUM_FILE_SIZE = 7340032;
    const SMTP_API_NAME = 'sendgrid/x-smtpapi';

    /**
     * Guzzle client instance.
     *
     * @var \GuzzleHttp\ClientInterface
     */
    protected $client;

    /**
     * The Sendgrid API key.
     *
     * @var string
     */
    protected $key;

    /**
     * API headers
     *
     * @var array
     */
    protected $headers;

    /**
     * @var array
     */
    protected $attachments;

    /**
     * @var int
     */
    protected $numberOfRecipients = 0;

    /**
     * Create a new Sendgrid transport instance.
     *
     * @param  \GuzzleHttp\ClientInterface  $client
     * @param  string  $key
     */
    public function __construct(ClientInterface $client, $key)
    {
        $this->setKey($key);
        $this->client = $client;

        $this->headers = [
            'Authorization' => 'Bearer ' . $this->getKey(),
            'Content-Type'  => 'application/json',
            'User-Agent: laravel/' . app()->version() . ';php',
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function send(Swift_Mime_Message $message, &$failedRecipients = null)
    {
        $this->beforeSendPerformed($message);

        $this->client->request(
            'POST',
            self::API_ENDPOINT,
            $this->payload($message)
        );

        $this->sendPerformed($message);

        return $this->numberOfRecipients($message);
    }

    /**
     * Get the HTTP payload for sending the Sendgrid message.
     *
     * @param  \Swift_Mime_Message  $message
     * @return array
     */
    protected function payload(Swift_Mime_Message $message)
    {
        $data = [
            'personalizations' => $this->getPersonalizations($message),
            'from'             => $this->getFrom($message),
            'subject'          => $message->getSubject(),
            'content'          => $this->getContents($message),
        ];

        $replyTo = $this->getReplyTo($message);
        if (!empty($replyTo)) {
            $data['reply_to'] = $replyTo;
        }

        $attachments = $this->getAttachments($message);
        if (count($attachments) > 0) {
            $data['attachments'] = $attachments;
        }

        return [
            'headers' => $this->headers,
            'json' => $this->setParameters($message, $data),
        ];
    }

    /**
     * Get the API key being used by the transport.
     *
     * @return string
     */
    public function getKey()
    {
        return $this->key;
    }

    /**
     * Set the API key being used by the transport.
     *
     * @param  string  $key
     * @return string
     */
    public function setKey($key)
    {
        return $this->key = $key;
    }

    /**
     * @param Swift_Mime_Message $message
     * @return array
     */
    private function getPersonalizations(Swift_Mime_Message $message)
    {
        $personalization['to'] = $this->normalizeContacts($message->getTo());
        if ($cc = $message->getCc()) {
            $personalization['cc'] = $this->normalizeContacts($cc);
        }
        if ($bcc = $message->getBcc()) {
            $personalization['bcc'] = $this->normalizeContacts($bcc);
        }

        return [$personalization];
    }

    /**
     * @param array $contacts
     * @return array
     */
    private function normalizeContacts(array $contacts)
    {
        return collect($contacts)->map(function ($name, $email) {
            return compact('name', 'email');
        })->values()->toArray();
    }

    /**
     * Get From Addresses.
     *
     * @param Swift_Mime_Message $message
     * @return array
     */
    private function getFrom(Swift_Mime_Message $message)
    {
        if ($message->getFrom()) {
            foreach ($message->getFrom() as $email => $name) {
                return ['email' => $email, 'name' => $name];
            }
        }

        return [];
    }

    /**
     * Get ReplyTo Addresses.
     *
     * @param Swift_Mime_Message $message
     * @return array
     */
    private function getReplyTo(Swift_Mime_Message $message)
    {
        if ($message->getReplyTo()) {
            foreach ($message->getReplyTo() as $email => $name) {
                return ['email' => $email, 'name' => $name];
            }
        }

        return [];
    }

    /**
     * Get contents.
     *
     * @param Swift_Mime_Message $message
     * @return array
     */
    private function getContents(Swift_Mime_Message $message)
    {
        $contentType = $message->getContentType();
        switch ($contentType) {
            case 'text/plain':
                return [
                    [
                        'type'  => 'text/plain',
                        'value' => $message->getBody(),
                    ],
                ];
            case 'text/html':
                return [
                    [
                        'type'  => 'text/html',
                        'value' => $message->getBody(),
                    ],
                ];
        }

        // Following RFC 1341, text/html after text/plain in multipart
        $content = [];
        foreach ($message->getChildren() as $child) {
            if ($child instanceof Swift_MimePart && $child->getContentType() === 'text/plain') {
                $content[] = [
                    'type'  => 'text/plain',
                    'value' => $child->getBody(),
                ];
            }
        }
        $content[] = [
            'type'  => 'text/html',
            'value' => $message->getBody(),
        ];

        return $content;
    }

    /**
     * @param Swift_Mime_Message $message
     * @return array
     */
    private function getAttachments(Swift_Mime_Message $message)
    {
        $attachments = [];
        foreach ($message->getChildren() as $attachment) {
            if (($attachment instanceof Swift_Attachment || $attachment instanceof Swift_Image)
                && $attachment->getFilename() !== self::SMTP_API_NAME
                && strlen($attachment->getBody()) <= self::MAXIMUM_FILE_SIZE
            ) {
                $attachments[] = [
                    'content'     => base64_encode($attachment->getBody()),
                    'filename'    => $attachment->getFilename(),
                    'type'        => $attachment->getContentType(),
                    'disposition' => $attachment->getDisposition(),
                    'content_id'  => $attachment->getId(),
                ];
            }
        }

        return $this->attachments = $attachments;
    }

    /**
     * Set Request Body Parameters
     *
     * @param Swift_Mime_Message $message
     * @param array $data
     * @return array
     * @throws \Exception
     */
    protected function setParameters(Swift_Mime_Message $message, $data)
    {
        $this->numberOfRecipients = 0;
        $smtpApi = [];
        foreach ($message->getChildren() as $attachment) {
            if (!$attachment instanceof Swift_Image
                || !in_array(self::SMTP_API_NAME, [$attachment->getFilename(), $attachment->getContentType()])
            ) {
                continue;
            }
            $smtpApi = $attachment->getBody();
        }
        if (!is_array($smtpApi)) {
            return $data;
        }
        foreach ($smtpApi as $key => $val) {
            switch ($key) {
                case 'personalizations':
                    $this->setPersonalizations($data, $val);
                    continue 2;
                case 'attachments':
                    $val = array_merge($this->attachments, $val);
                    break;
                case 'unique_args':
                    throw new \Exception('Sendgrid v3 now uses custom_args instead of unique_args');
                case 'custom_args':
                    foreach ($val as $name => $value) {
                        if (!is_string($value)) {
                            throw new \Exception('Sendgrid v3 custom arguments have to be a string.');
                        }
                    }
                    break;
            }
            array_set($data, $key, $val);
        }

        return $data;
    }

    /**
     * @param array $data
     * @param array $personalizations
     */
    private function setPersonalizations(&$data, $personalizations)
    {
        foreach ($personalizations as $index => $params) {
            foreach ($params as $key => $val) {
                if (in_array($key, ['to', 'cc', 'bcc'])) {
                    array_set($data, 'personalizations.' . $index . '.' . $key, [$val]);
                    ++$this->numberOfRecipients;
                } else {
                    array_set($data, 'personalizations.' . $index . '.' . $key, $val);
                }
            }
        }
    }
}
