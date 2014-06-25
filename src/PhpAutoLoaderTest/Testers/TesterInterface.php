<?php

namespace PhpAutoLoaderTest\Testers;

use PhpAutoLoaderTest\NameOccurance;

/**
 * Interface for mechanisms that can tests if classes and interfaces 
 * can be loaded using an autoloader
 **/
interface TesterInterface {
  
  /**
   * Tests if class can be loaded using an autoloader
   *
   * @param NameOccurance classname or interfaceName
   * @return boolean true on success
   **/
  public function canLoad(NameOccurance $name);  

}
