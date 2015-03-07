<?php


namespace PhpAutoLoader\tests;


use PhpAutoLoaderTest\File;

class FileTest extends \PHPUnit_Framework_TestCase {

    public function testConstructorSetsFilename(){
        $f = new File('contents', 'filename.php');
        $this->assertEquals('filename.php' ,$f->fileName());
    }


    public function testConstructorSetsContents(){
        $f = new File('contents');
        $this->assertEquals('contents' ,$f->contents());
    }


}
