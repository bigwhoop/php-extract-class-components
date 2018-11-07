<?php
declare(strict_types=1);

namespace Bigwhoop\PhpClassComponentsExtractor\Formatting;

use Bigwhoop\PhpClassComponentsExtractor\Graph\Graph;
use Bigwhoop\PhpClassComponentsExtractor\Graph\MethodRef;
use Bigwhoop\PhpClassComponentsExtractor\Graph\PropertyRef;

final class JsonFormatter
{
    public function format(Graph $graph): string
    {
        $components = $graph->getComponents();
        
        $data = [];
        foreach ($components->all() as $idx => $component) {
            $data[$idx] = ['methods' => [], 'properties' => []];
            foreach ($component->getReferences() as $reference) {
                switch (\get_class($reference)) {
                    case MethodRef::class: $type = 'methods'; break;
                    case PropertyRef::class: $type = 'properties'; break;
                    default: throw new \OutOfRangeException();
                }
                $data[$idx][$type][] = $reference->toString();
            }
        }
        
        return json_encode($data, JSON_PRETTY_PRINT);
    }
}
