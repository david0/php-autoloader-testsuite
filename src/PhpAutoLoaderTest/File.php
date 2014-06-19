<?php

namespace PhpAutoLoaderTest;


class File {

    private $filename;
    private $contents;

    public function __construct($contents, $filename=null) {
       $this->contents = $contents;
       $this->filename=$filename;
    }

    public function contents() {
        return $this->contents;
    }

    public function fileName(){
        return $this->filename;
    }


} 