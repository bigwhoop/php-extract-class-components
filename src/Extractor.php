<?php
declare(strict_types=1);

namespace Bigwhoop\PhpClassComponentsExtractor;

use Bigwhoop\PhpClassComponentsExtractor\Graph\Graph;
use PhpParser\Error;
use PhpParser\NodeTraverser;
use PhpParser\Parser;
use PhpParser\ParserFactory;

final class Extractor
{
    /** @var Parser */
    private $parser;
    /** @var NodeVisitor */
    private $nodeVisitor;
    /** @var NodeTraverser */
    private $traverser;

    public function __construct()
    {
        $this->parser = (new ParserFactory)->create(ParserFactory::PREFER_PHP7);
        $this->nodeVisitor = new NodeVisitor();
        
        $traverser = new NodeTraverser();
        $traverser->addVisitor($this->nodeVisitor);
        $this->traverser = $traverser;
    }
    
    public function extract(Source $source): Graph
    {
        try {
            $ast = $this->parser->parse($source->getCode());
        } catch (Error $e) {
            throw $e;
        }
        
        $this->nodeVisitor->reset();
        $this->traverser->traverse($ast);
        
        return $this->nodeVisitor->getGraph();
    }
}
