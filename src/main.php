<?php
/**
 * Application Entry Point
 */

$autoloader = require_once __DIR__.'/../vendor/autoload.php';

use PhpAutoLoaderTest\File;
use PhpParser\Node;

if($argc!=3)
    die(sprintf("USAGE: %s [bootstrap] [directory]\n", $argv[0]));

$bootstrap = $argv[1];
if(!is_file($bootstrap))
    die(sprintf("%s is not a file!\n", $bootstrap));

$directoryPath = $argv[2];
if(!is_dir($directoryPath))
    die(sprintf("%s is not a directory!\n", $directoryPath));


$files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($directoryPath));
$files = new RegexIterator($files, '/\.(php|inc)$/');


$scanner = new \PhpAutoLoaderTest\NameScanner();
$names = array();
foreach ($files as $fileName) {
    try {

            $file = new File(file_get_contents($fileName), $fileName);
            $namesInThisFile = $scanner->collectClassNames($file);
            $names = array_merge($names, $namesInThisFile);
    } catch (PhpParser\Error $e) {
        printf('%s: Parse Error: %s \n', $file->fileName(), $e->getMessage());
    }
}

//unregister our autoloader and use foreign boostrap
$autoloader->unregister();

require_once $bootstrap;

foreach($names as $name) {

    // class_exists triggers the autoloader in order to find out if class name can be resolved
    $wasLoaded = class_exists($name->fullyQualifiedName()) || interface_exists($name->fullyQualifiedName());

    if(!$wasLoaded) {
        printf("%s: Failed to load: %s\n", $name->file()->fileName(), $name->fullyQualifiedName());
    }
}
