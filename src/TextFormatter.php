<?php
declare(strict_types=1);

namespace Bigwhoop\PhpClassComponentsExtractor;

use Bigwhoop\PhpClassComponentsExtractor\Graph\Graph;

final class TextFormatter
{
    public function format(Graph $graph): string
    {
        $components = $graph->getComponents();
        
        $s = '';
        foreach ($components->all() as $idx => $component) {
            $num = $idx + 1;
            $s .= "Component #{$num}\n";
            foreach ($component->getReferences() as $reference) {
                $s .= "  {$reference->toString()}\n";
            }
            $s .= "\n";
        }
        
        return trim($s);
    }
}
