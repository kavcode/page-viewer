<?php declare(strict_types=1);

namespace App\Tests\Unit\Markdown\LineWalkers;

use App\Markdown\LineWalkers\EmailParser;
use Codeception\Test\Unit;

class EmailParserTest extends Unit
{
    public function testEmailParser(): void
    {
        $walker = new EmailParser();
        $this->assertEquals(
            ['foo', '<a href="mailto:john@example.com">john@example.com</a>'],
            $walker->walk(['foo', 'john@example.com'])
        );
    }
}