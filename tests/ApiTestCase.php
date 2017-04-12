<?php
namespace Tests;
use Faker\Factory;
abstract class ApiTestCase extends TestCase
{
    /**
     * The base URL to use while testing the application.
     *
     * @var string
     */

    protected $baseUrl = 'http://localhost';

    /**
     * Faker.
     *
     * @var \Faker\Generator
     */
    protected $fake;

    public function setUp()
    {
        parent::setUp();
        $this->fake = Factory::create();
    }
}
