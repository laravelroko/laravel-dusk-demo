<?php

namespace Tests;

use Illuminate\Support\Facades\Log;
//use BeyondCode\DuskDashboard\Testing\TestCase as BaseTestCase;
use Laravel\Dusk\TestCase as BaseTestCase;
use Facebook\WebDriver\Chrome\ChromeOptions;
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
        $options = (new ChromeOptions)->addArguments([
            '--disable-gpu',
            '--headless',
            '--window-size=1920,1080',
        ]);

        return RemoteWebDriver::create(
            'http://localhost:9515', DesiredCapabilities::chrome()->setCapability(
                ChromeOptions::CAPABILITY, $options
            )
        );
    }

    /**
     * Create the RemoteWebDriver instance.
     *
     * @return \Facebook\WebDriver\Remote\RemoteWebDriver
     */
//    protected function driver()
//    {
//        return RemoteWebDriver::create(
//            'http://localhost:4444/wd/hub', DesiredCapabilities::phantomjs()
//        );
//    }

    public function exceptionLogging(\Exception $ex)
    {
        $message = json_encode([
            'Code' => $ex->getCode(),
            'Message' => $ex->getMessage(),
            'File' => $ex->getFile(),
            'Line' => $ex->getLine()
        ]);

        Log::debug($message);

    }
}
