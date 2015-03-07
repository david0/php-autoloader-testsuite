<?php

namespace PhpAutoLoaderTest\tests\Testers;

use PhpAutoLoaderTest\Testers\ProcessIsolationTester;
use PhpAutoLoaderTest\NameOccurance;


class ProcessIsolationTesterTest extends \PHPUnit_Framework_TestCase
{

    /** @var \PhpAutoLoaderTest\Testers\TesterInterface */
    private $tester;

    public function setUp()
    {
        parent::setUp();
        $autoloaderPath = __DIR__ . '/../../vendor/autoload.php';
        $this->tester = new ProcessIsolationTester($autoloaderPath);
    }

    public function testReturnsTrueForThisClass()
    {
        $name = new NameOccurance(__CLASS__);
        $this->assertTrue($this->tester->canLoad($name));
    }

    public function testReturnsFalseForDummyClass()
    {
        $name = new NameOccurance('Foo\Bar');
        $this->assertFalse($this->tester->canLoad($name));
    }


}
 
