<?php

namespace PhpAutoLoaderTest;


use PhpParser;


class NameScanner
{

    public function collectClassNames(File $file)
    {
        $parser = new \PhpParser\Parser(new \PhpParser\Lexer);
        $traverser = new \PhpParser\NodeTraverser;

        $traverser->addVisitor(new \PhpParser\NodeVisitor\NameResolver); // we will need resolved names
        $classNameCollector = new \PhpAutoLoaderTest\ClassNameCollectorVisitor($file);
        $traverser->addVisitor($classNameCollector);

        $stmts = $parser->parse($file->contents());
        $traverser->traverse($stmts);

        return $classNameCollector->collectedNameDeclarations();
    }


}