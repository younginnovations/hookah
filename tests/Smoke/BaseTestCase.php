<?php

namespace YIPL\Hookah\Test\Smoke;

use GuzzleHttp\Client;

/**
 * Class BaseTestCase
 * @package Test\Smoke
 */
class BaseTestCase extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Client
     */
    protected $client;

    /**
     * Constructor
     *
     * @param null $name
     * @param array $data
     * @param string $dataName
     */
    public function __construct($name = null, $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);

        $this->baseUrl = 'http://drupal-test.jelastic.elastx.net/';
        $this->client = new Client(
            [
                'base_url'        => $this->baseUrl,
                'cookies'         => true,
                'allow_redirects' => false
            ]
        );
    }

    protected function printLn($string)
    {
        print sprintf('%s%s', $string, PHP_EOL);
    }

    protected function printSeparator()
    {
        print sprintf('%s===============================================%s', PHP_EOL, PHP_EOL);
    }
}
