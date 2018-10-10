<?php

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Parsedown;

class MarkdownParserExtension extends AbstractExtension
{
    public function getFilters(): array
    {
        return [
            new TwigFilter('markdown', [$this, 'parse'], ['is_safe' => ['html']])
        ];
    }

    public function parse(string $content): string
    {
        return (new Parsedown())->text($content);
    }
}
