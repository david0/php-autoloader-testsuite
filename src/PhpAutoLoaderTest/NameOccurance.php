<?php

namespace PhpAutoLoaderTest;


class NameOccurance {

    private $file;
    private $fullyQualifiedName;

    public function __construct($fullyQualifiedName, File $file) {
        $this->fullyQualifiedName = $fullyQualifiedName;
        $this->file = $file;
    }

    /**
     * @return string
     */
    public function fullyQualifiedName()
    {
        return $this->fullyQualifiedName;
    }

    /**
     * @return File
     */
    public function file() {
       return $this->file;
    }

}
