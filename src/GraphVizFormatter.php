<?php
declare(strict_types=1);

namespace Bigwhoop\PhpClassComponentsExtractor;

use Bigwhoop\PhpClassComponentsExtractor\Graph\Graph;
use Bigwhoop\PhpClassComponentsExtractor\Graph\MethodRef;
use Bigwhoop\PhpClassComponentsExtractor\Graph\PropertyRef;

final class GraphVizFormatter
{
    public function format(Graph $graph): string
    {
        $components = $graph->getComponents();
        
        $s = "digraph {\n";
        $s .= "    graph[fontname=\"Arial\"];\n";
        $s .= "    node[fontname=\"Arial\", fontsize=10];\n";
        $s .= "    edge[fontname=\"Arial\", fontsize=10];\n";
        $s .= "\n";
        
        foreach ($components->all() as $idx => $component) {
            $num = $idx + 1;
            
            $s .= "    subgraph cluster_{$idx} {\n";
            $s .= "        label=\"Component #{$num}\";\n";
            
            foreach ($component->getReferences() as $ref) {
                if ($ref instanceof PropertyRef) {
                    $s .= "        \"{$ref->toString()}\";\n";
                } elseif ($ref instanceof MethodRef) {
                    $s .= "        \"{$ref->toString()}\"[shape=\"box\", style=\"filled\", fillcolor=\"lightgrey\"];\n";
                }
            }
            
            $s .= "    }\n";
            $s .= "\n";
        }
        
        foreach ($graph->getMethods() as $method) {
            $methodRef = new MethodRef($method);
            foreach ($graph->getRefsForMethod($method) as $ref) {
                $s .= "    \"{$methodRef->toString()}\" -> \"{$ref->toString()}\"\n";
            }
        }
        
        $s .= "}\n";
        
        return trim($s);
    }
}
