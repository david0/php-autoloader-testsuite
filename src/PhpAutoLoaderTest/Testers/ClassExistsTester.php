<?php

namespace PhpAutoLoaderTest\Testers;

use PhpAutoLoaderTest\NameOccurance;

/**
 * Tester that loads classes and interfaces in the same namespace than 
 * PhpAutloader itself. 
 *
 * Due files side-effects like require_once this may cause false results.
 **/
class ClassExistsTester implements TesterInterface {

  /**
   * @param string boostrap filename of boostrap script
   **/
  public function __construct($boostrap=null) {
    if($boostrap !== null)
      require_once $boostrap;
  }

  public function canLoad(NameOccurance $name) {
    // class_exists triggers the autoloader in order to find out if class name can be resolved
    return class_exists($name->fullyQualifiedName()) || interface_exists($name->fullyQualifiedName());
  }

}
