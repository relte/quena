<?php

namespace App\Tests;

use App\Twig\MarkdownParserExtension;
use Codeception\Test\Unit;
use Twig\TwigFilter;

class MarkdownParserExtensionTest extends Unit
{
    /**
     * @test
     */
    public function itProvidesMarkdownFilter(): void
    {
        $extension = new MarkdownParserExtension();

        verify($extension->getFilters())->equals([
            new TwigFilter('markdown', [$extension, 'parse'], ['is_safe' => ['html']])
        ]);
    }

    /**
     * @test
     */
    public function itParsesMarkdown(): void
    {
        $extension = new MarkdownParserExtension();

        verify($extension->parse('_Emphasized phrase_'))
            ->equals('<p><em>Emphasized phrase</em></p>');
    }
}
