<?php

namespace PhpAutoLoaderTest\Testers;

use PhpAutoLoaderTest\NameOccurance;

/**
 * Tester that loads classes and interfaces 
 *
 **/
class ProcessIsolationTester implements TesterInterface {

  /** @var string filename of bootstrap script */
  private $bootstrapScript;

  /**
   * @param string bootstrap filename of bootstrap script
   **/
  public function __construct($bootstrapScript) {
    $this->bootstrapScript = $bootstrapScript;
  }

  public function canLoad(NameOccurance $name) {
      $result = 0;
      $command = sprintf("php -r \"require_once '%s'; exit(class_exists('%s')|interface_exists('%s'));\"", $this->bootstrapScript, $name->fullyQualifiedName(), $name->fullyQualifiedName());
      system($command, $result);
      return $result === 1;
  }

}
