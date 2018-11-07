<?php
declare(strict_types=1);

namespace Bigwhoop\PhpClassComponentsExtractor;

use Bigwhoop\PhpClassComponentsExtractor\Graph\Graph;
use PhpParser\Node;
use PhpParser\NodeVisitorAbstract;

final class NodeVisitor extends NodeVisitorAbstract
{
    private static $methodsToIgnore = ['__construct', '__destruct', '__clone'];
    
    /** @var Graph */
    private $graph;
    /** @var string */
    private $lastMethod = '';

    public function __construct()
    {
        $this->reset();
    }

    public function reset(): void
    {
        $this->graph = new Graph();
    }
    
    public function enterNode(Node $node) 
    {
        if ($node instanceof Node\Stmt\PropertyProperty) {
            $this->graph->addProperty($node->name->toString());
        }
        
        if ($node instanceof Node\Stmt\ClassMethod && !\in_array($node->name->toString(), self::$methodsToIgnore, true)) {
            $this->graph->addMethod($node->name->toString());
            $this->lastMethod = $node->name->toString();
        }
        
        if ($this->lastMethod === '') {
            return null;
        }
        
        if ($node instanceof Node\Expr\PropertyFetch && $node->var instanceof Node\Expr\Variable && $node->var->name === 'this') {
            $this->graph->addPropertyFetch($this->lastMethod, $node->name->name);
        }
        
        if ($node instanceof Node\Expr\MethodCall && $node->var instanceof Node\Expr\Variable && $node->var->name === 'this') {
            $this->graph->addMethodCall($this->lastMethod, $node->name->name);
        }
        
        return null;
    }
    
    public function getGraph(): Graph
    {
        return $this->graph;
    }
}