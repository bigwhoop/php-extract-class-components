<?php
declare(strict_types=1);

namespace Bigwhoop\PhpClassComponentsExtractor\Graph;

final class Component
{
    /** @var Reference[] */
    private $refs = [];

    /**
     * @param Reference[] $refs
     * @return void
     */
    public function addReferences(array $refs): void
    {
        foreach ($refs as $ref) {
            $this->addReference($ref);
        }
    }
    
    public function addReference(Reference $ref): void
    {
        $this->refs[$ref->toString()] = $ref;
    }

    /**
     * @param Reference[] $refs
     * @return bool
     */
    public function containsOneOf(array $refs): bool
    {
        foreach ($refs as $ref) {
            if (\array_key_exists($ref->toString(), $this->refs)) {
                return true;
            }
        }
        
        return false;
    }

    /**
     * @return Reference[]
     */
    public function getReferences(): array
    {
        ksort($this->refs);
        
        return $this->refs;
    }
    
    public function countReferences(): int
    {
        return count($this->refs);
    }
}