<?php


namespace PhpAutoLoaderTest;

use PHPParser\Node;
use PHPParser\Node\Name;
use PhpParser\Node\Stmt;
use PHPParser\Node\Expr;
use PhpParser\NodeVisitorAbstract;

class ClassNameCollectorVisitor extends NodeVisitorAbstract
{
    private $nameDeclarations = array();

    private $file;

    public function __construct(File $file) {
        $this->file = $file;
    }

    public function enterNode(Node $node) {


        if (($node instanceof Expr\New_ && $node->class instanceof Name) or
            ($node instanceof Expr\ClassConstFetch) or
            ($node instanceof Expr\StaticCall && $node->class instanceof Name)
        ) {
            $this->nameDeclarations[] = new NameOccurance($node->class->toString(), $this->file);
        }

        if ($node instanceof Stmt\UseUse) {
            $this->nameDeclarations[] = new NameOccurance($node->name->toString(), $this->file);
        }

        if ($node instanceof Stmt\Class_) {
            //$this->nameDeclarations[] = new NameOccurance($node->name, $this->file);

            if ($node->extends) {
                $this->nameDeclarations[] = new NameOccurance($node->extends->toString(), $this->file);
            }

            foreach ($node->implements as $implement) {
                $this->nameDeclarations[] = new NameOccurance($implement->toString(), $this->file);
            }
        }
    }

    /**
     * @return NameOccurance[]
     */
    public function collectedNameDeclarations()
    {
        $withoutKeywords = array_filter($this->nameDeclarations, function (NameOccurance $occurance) {
            return !in_array($occurance->fullyQualifiedName(), array('static', 'parent', 'self'));
        });
        return $withoutKeywords;
    }

}