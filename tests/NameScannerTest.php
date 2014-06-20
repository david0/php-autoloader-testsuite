<?php

namespace PhpAutoLoaderTest\tests;

use PhpAutoLoaderTest\File;
use PhpAutoLoaderTest\NameScanner;


/**
 * Verifies that all names that will trigger autoload will be detected
 *
 * @coversDefault NameScanner
 */
class NameScannerTest extends \PHPUnit_Framework_TestCase {

    /**
     * @var NameScanner
     */
    private $scanner;

    public function setUp(){
        $this->scanner = new NameScanner();
    }

    /**
     * Provides testcases for an one-liner source code that contains one class name
     * that is relevant for the autoloader
     * @return array
     */
    public function codeNamesProvider() {
        return array(
          array('<?php new Bar(); ', 'Bar'),
          array('<?php namespace Foo; new Bar(); ', 'Foo\Bar'),
          //array('<?php use A\B; new B\C(); ', 'A\B\C'),
          array('<?php Bar::CONSTANT; ', 'Bar'),
          array('<?php Foo::bar(); ', 'Foo')
        );
    }

    /**
     * Tests if the name is resolved from the given sourcecode
     * (can only test for one name)
     *
     * @dataProvider codeNamesProvider
     * @param string $code
     * @param string $name
     */
    public function testResolveCodeName($code, $name) {
        $file = new File($code);
        $usedClassNames = $this->scanner->collectClassNames($file);

        $this->assertEquals(array($name), $this->getFullyQualifiedNames($usedClassNames));
    }

    public function testDoesNotResolveUse() {
        $file = new File('<?php use Foo;');
        $usedClassNames = $this->scanner->collectClassNames($file);
        $this->assertEmpty($usedClassNames);
    }

    public function testResolveExtends() {
        $file = new File('<?php class Foo extends Bar {}');
        $usedClassNames = $this->scanner->collectClassNames($file);

        $this->assertEquals(array('Bar'), $this->getFullyQualifiedNames($usedClassNames));
    }

    public function testResolveImplements() {
        $file = new File('<?php class Foo implements Bar, X {}');
        $usedClassNames = $this->scanner->collectClassNames($file);

        $this->assertEquals(array('Bar', 'X'), $this->getFullyQualifiedNames($usedClassNames));
    }


    public function keywordProvider() {
        return array(
            array('parent'),
            array('self'),
            array('static')
        );
    }

    /**
     * @dataProvider keywordProvider
     */
    public function testWillNotResolveKeywords($keyword) {
        $file = new File("<?php $keyword::bar; ");
        $usedClassNames = $this->scanner->collectClassNames($file);

        $this->assertEmpty($usedClassNames);
    }

    public function testSetsFileName() {
        $file = new File('<?php new Foo();','Foo.php');
        $usedClassNames = $this->scanner->collectClassNames($file);

        $this->assertCount(1, $usedClassNames);
        $this->assertEquals($file, $usedClassNames[0]->file());
    }


    /**
     * Extract FQNs from name occurrances
     *
     * @param NameOccurance[] $names
     * @return string
     */
    private function getFullyQualifiedNames(array $names) {
        return array_map(function ($e) {return $e->fullyQualifiedName();}, $names);
    }
}
 
