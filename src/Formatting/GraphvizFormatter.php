<?php
declare(strict_types=1);

namespace Bigwhoop\PhpClassComponentsExtractor\Formatting;

use Bigwhoop\PhpClassComponentsExtractor\Graph\Graph;
use Bigwhoop\PhpClassComponentsExtractor\Graph\MethodRef;
use Bigwhoop\PhpClassComponentsExtractor\Graph\PropertyRef;

final class GraphvizFormatter
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
        
        $methods = $graph->getMethods();
        
        foreach ($methods as $method) {
            $methodRef = new MethodRef($method);
            $calls = [];
            foreach ($graph->getRefsForMethod($method) as $ref) {
                if ($ref instanceof MethodRef && !\in_array($ref->getName(), $methods, true)) {
                    continue; // ignore methods not found directly on the class. e.g. methods from traits or base classes
                }
                
                $calls[] = "    \"{$methodRef->toString()}\" -> \"{$ref->toString()}\"\n";
            }
            $s .= join('', array_unique($calls));
        }
        
        $s .= "}\n";
        
        return trim($s);
    }
}
