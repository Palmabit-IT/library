<?php namespace Palmabit\Library\Tests;
/**
 * Test TestCase
 *
 * @author jacopo beschi jacopo@jacopobeschi.com
 */
class TestCase extends \Orchestra\Testbench\TestCase  {

    public function setUp()
    {
        parent::setUp();
    }

    protected function getPackageProviders()
    {
        return [
            'Palmabit\Library\LibraryServiceProvider',
        ];
    }

    protected function getPackageAliases()
    {
        return [
        ];
    }
}