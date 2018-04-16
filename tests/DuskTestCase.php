<?php

namespace Tests;

use Facebook\WebDriver\Chrome\ChromeOptions;
use Laravel\Dusk\TestCase as BaseTestCase;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\Remote\DesiredCapabilities;

abstract class DuskTestCase extends BaseTestCase
{
    use CreatesApplication;

    /**
     * Prepare for Dusk test execution.
     *
     * @beforeClass
     * @return void
     */
    public static function prepare()
    {
        static::startChromeDriver();
    }

    /**
     * Create the RemoteWebDriver instance.
     *
     * @return \Facebook\WebDriver\Remote\RemoteWebDriver
     */
    protected function driver()
    {
        $desiredCapabilities = DesiredCapabilities::chrome();

        if (config('dusk.chrome_bin')) {
            $options = new ChromeOptions();
            $options->setBinary(config('dusk.chrome_bin'));
            $options->addArguments([
                '--headless',
                // avoid an error from a missing Mesa library
                '--disable-gpu',
            ]);

            $desiredCapabilities->setCapability(ChromeOptions::CAPABILITY, $options);
        }

        return RemoteWebDriver::create(
            config('dusk.selenium_server_url'),
            $desiredCapabilities,
            5000,
            50000
        );
    }
}
