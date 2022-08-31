<?php

declare(strict_types=1);

namespace App\Tests\Unit\Markdown\LineWalkers;

use App\Markdown\LineWalkers\EmailParser;
use App\Markdown\LineWalkers\LinksParser;
use Codeception\Test\Unit;

class LinkParserTest extends Unit
{
    public function testLinkParser(): void
    {
        $walker = new LinksParser();
        $this->assertEquals(
            ['foo', '<a href="http://example.com">http://example.com</a>'],
            $walker->walk(['foo', 'http://example.com'])
        );

        $this->assertEquals(
            ['foo', '<a href="https://example.com">https://example.com</a>'],
            $walker->walk(['foo', 'https://example.com'])
        );

        $this->assertEquals(
            ['foo', '<a href="ftp://example.com/foo.zip">ftp://example.com/foo.zip</a>'],
            $walker->walk(['foo', 'ftp://example.com/foo.zip'])
        );
    }
}
