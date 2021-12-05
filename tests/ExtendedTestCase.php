<?php

namespace ShareButtons\Share\Test;

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
        return ['ShareButtons\Share\Providers\ShareButtonsServiceProvider'];
    }
}
