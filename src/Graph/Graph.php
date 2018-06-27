<?php
declare(strict_types=1);

namespace Bigwhoop\PhpClassComponentsExtractor\Graph;

final class Graph
{
    private $properties = [];
    private $methods = [];
    
    public function addProperty(string $property): void
    {
        if (!\in_array($property, $this->properties, true)) {
            $this->properties[] = $property;
        }
    }
    
    public function addMethod(string $method): void
    {
        if (!\array_key_exists($method, $this->methods)) {
            $this->methods[$method] = [];
        }
    }
    
    public function addPropertyFetch(string $caller, string $property): void
    {
        $this->addMethod($caller);
        $this->addProperty($property);
        $this->methods[$caller][] = new PropertyRef($property);
    }
    
    public function addMethodCall(string $caller, string $callee): void
    {
        $this->addMethod($caller);
        $this->addMethod($callee);
        $this->methods[$caller][] = new MethodRef($callee);
    }

    /**
     * @param string $method
     * @return Reference[]
     */
    public function getRefsForMethod(string $method): array
    {
        return $this->methods[$method] ?? [];
    }
    
    public function getComponents(): Components
    {
        /** @var Component[] $components */
        $components = [];
        
        $processedMethods = [];
        
        foreach ($this->getMethodRefsByProperty() as $property => $callers) {
            /** @var Reference[] $callers */
            
            $refs = [new PropertyRef($property)];
            foreach ($callers as $caller) {
                $processedMethods[] = substr($caller->toString(), 0, -2); // drop ()
                $refs[] = $caller;
            }
            
            foreach ($components as $component) {
                if ($component->containsOneOf($refs)) {
                    $component->addReferences($refs);
                    continue 2;
                }
            }
            
            $component = new Component();
            $component->addReferences($refs);
            $components[] = $component;
        }
        
        foreach (array_diff(array_keys($this->methods), $processedMethods) as $method) {
            $component = new Component();
            $component->addReference(new MethodRef($method));
            $components[] = $component;
        }
        
        return new Components($components);
    }
    
    private function getMethodRefsByProperty(): array
    {
        $properties = [];
        foreach ($this->properties as $property) {
            $properties[$property] = [];
        }
        
        foreach ($this->methods as $method => $refs) {
            /** @var Reference[] $refs */
            foreach ($refs as $ref) {
                foreach ($ref->resolveToPropertyNames($this) as $prop) {
                    $properties[$prop][$method] = new MethodRef($method);
                }
            }
        }
        
        return array_map('array_values', $properties);
    }

    /**
     * @return string[]
     */
    public function getMethods(): array
    {
        return array_keys($this->methods);
    }
}