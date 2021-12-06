<?php

namespace Kudashevs\ShareButtons\Tests;

use Orchestra\Testbench\TestCase as BaseTestCase;

class ExtendedTestCase extends BaseTestCase
{
    /**
     * Load Laravel share service provider
     *
     * @param \Illuminate\Foundation\Application $application
     * @return array
     */
    protected function getPackageProviders($application)
    {
        return ['Kudashevs\ShareButtons\Providers\ShareButtonsServiceProvider'];
    }
}
