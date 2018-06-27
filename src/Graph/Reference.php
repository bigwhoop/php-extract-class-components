<?php
declare(strict_types=1);

namespace Bigwhoop\PhpClassComponentsExtractor\Graph;

interface Reference
{
    /**
     * @param Graph $graph
     * @return string[]
     */
    public function resolveToPropertyNames(Graph $graph): array;
    
    public function toString(): string;
}