<?php

namespace PhpAutoLoaderTest\tests\Testers;

use PhpAutoLoaderTest\Testers\ClassExistsTester;
use PhpAutoLoaderTest\NameOccurance;


class ClassExistsTesterTest extends \PHPUnit_Framework_TestCase
{

    public function testReturnsTrueForThisClass()
    {
        $tester = new ClassExistsTester();
        $name = new NameOccurance(__CLASS__);
        $this->assertTrue($tester->canLoad($name));
    }

    public function testReturnsFalseForDummyClass()
    {
        $tester = new ClassExistsTester();
        $name = new NameOccurance('Foo\Bar');
        $this->assertFalse($tester->canLoad($name));
    }


}
 
