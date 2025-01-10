<?php

namespace Kudashevs\ShareButtons\Tests;

use Orchestra\Testbench\TestCase as BaseTestCase;

class TestCase extends BaseTestCase
{
    /**
     * Load a Laravel ShareButtons service provider.
     *
     * @param \Illuminate\Foundation\Application $application
     * @return array<int, class-string>
     */
    protected function getPackageProviders($application)
    {
        return ['Kudashevs\ShareButtons\Providers\ShareButtonsServiceProvider'];
    }
}
