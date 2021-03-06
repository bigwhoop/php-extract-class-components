# php-class-components-extractor

This little tool helps you visualize the cohesion of a class by showing the relationship between its methods and properties. It helps you following the SRP (Single Responsiblity Principle) by showing you how a class could be split up.

```php
class Example
{
    private $a;
    private $b;
    private $c;
    
    public function a(): void
    {
        $this->a;
    }
    
    public function ab(): void
    {
        $this->a;
        $this->b;
    }
    
    public function c(): void
    {}
}
```

![Example](/screenshot.png?raw=true "Example")

## Installation

    composer require bigwhoop/php-extract-class-components
    
## Use

    vendor/bin/php-class-components-extractor Path/To/Your/Class.php
    
By default the output is in Graphviz's graph description language. You can pass that on to f.e. generate an image of your components.

    # make sure graphviz is installed
    sudo apt install graphviz
    
    # generate PNG
    vendor/bin/php-class-components-extractor Path/To/Your/Class.php | dot -Tpng -o diagram.png

