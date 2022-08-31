<?php

declare(strict_types=1);

namespace App\Markdown;

use App\Markdown\BlockCollectionWalkers\HeaderWalker;
use App\Markdown\BlockCollectionWalkers\ListItemWalker;
use App\Markdown\BlockCollectionWalkers\SubHeaderWalker;
use App\Markdown\BlockCollectionWalkers\UnorderedListWalker;
use App\Markdown\LineWalkers\EmailParser;
use App\Markdown\LineWalkers\LinksParser;

class ParserFactory
{
    public function create(): Parser
    {
        $parser = new Parser(new BlocksExtractor(), new WordSplitter(), new HtmlWriter());
        $parser->addLineWalker(new LinksParser());
        $parser->addLineWalker(new EmailParser());
        $parser->addBlockCollectionWalker(new HeaderWalker());
        $parser->addBlockCollectionWalker(new SubHeaderWalker());
        $parser->addBlockCollectionWalker(new UnorderedListWalker());
        return $parser;
    }
}
