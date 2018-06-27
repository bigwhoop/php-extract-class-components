<?php
declare(strict_types=1);

namespace Bigwhoop\PhpClassComponentsExtractor\Graph;

final class Components
{
    /** @var Component[] */
    private $components;

    /**
     * @param Component[]
     */
    public function __construct(array $components)
    {
        $this->components = $components;
        
        usort($this->components, function(Component $a, Component $b) {
            return $b->countReferences() - $a->countReferences();
        });
    }

    /**
     * @return Component[]
     */
    public function all(): array
    {
        return $this->components;
    }
}