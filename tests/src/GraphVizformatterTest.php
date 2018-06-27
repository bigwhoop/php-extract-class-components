<?php
declare(strict_types=1);

namespace Bigwhoop\PhpClassComponentsExtractor\Tests;

use Bigwhoop\PhpClassComponentsExtractor\Extractor;
use Bigwhoop\PhpClassComponentsExtractor\File;
use Bigwhoop\PhpClassComponentsExtractor\GraphvizFormatter;
use PHPUnit\Framework\TestCase;

final class GraphVizformatterTest extends TestCase
{
    /** @test */
    public function i_can_get_output_in_graphviz_graph_definition_language(): void
    {
        $extractor = new Extractor();
        $graph = $extractor->extract(new File(__DIR__ . '/../res/One.php'));
        
        $expected = <<<'TXT'
digraph {
    graph[fontname="Arial"];
    node[fontname="Arial", fontsize=10];
    edge[fontname="Arial", fontsize=10];

    subgraph cluster_0 {
        label="Component #1";
        "$a";
        "$b";
        "a()"[shape="box", style="filled", fillcolor="lightgrey"];
        "b()"[shape="box", style="filled", fillcolor="lightgrey"];
        "getA()"[shape="box", style="filled", fillcolor="lightgrey"];
        "getAB()"[shape="box", style="filled", fillcolor="lightgrey"];
        "getB()"[shape="box", style="filled", fillcolor="lightgrey"];
    }

    subgraph cluster_1 {
        label="Component #2";
        "$two";
        "x()"[shape="box", style="filled", fillcolor="lightgrey"];
        "y()"[shape="box", style="filled", fillcolor="lightgrey"];
    }

    subgraph cluster_2 {
        label="Component #3";
        "$c";
    }

    subgraph cluster_3 {
        label="Component #4";
        "d()"[shape="box", style="filled", fillcolor="lightgrey"];
    }

    "a()" -> "$a"
    "getA()" -> "$a"
    "b()" -> "$b"
    "getB()" -> "b()"
    "getAB()" -> "$a"
    "getAB()" -> "getB()"
    "x()" -> "$two"
    "y()" -> "$two"
}
TXT;
        
        $this->assertSame($expected, (new GraphvizFormatter())->format($graph));
    }
}