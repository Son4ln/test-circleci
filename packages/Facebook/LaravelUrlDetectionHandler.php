<?php

namespace Rabiloo\Facebook;

use Facebook\Url\UrlDetectionInterface;
use Illuminate\Contracts\Routing\UrlGenerator;

class LaravelUrlDetectionHandler implements UrlDetectionInterface
{
    /**
     * @var UrlGenerator
     */
    protected $url;

    /**
     * LaravelUrlDetectionHandler constructor.
     *
     * @param UrlGenerator $url
     */
    public function __construct(UrlGenerator $url)
    {
        $this->url = $url;
    }

    /**
     * Get the currently active URL.
     *
     * @return string
     */
    public function getCurrentUrl()
    {
        return $this->url->current();
    }
}
