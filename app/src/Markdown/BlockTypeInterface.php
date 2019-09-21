<?php declare(strict_types=1);

namespace App\Markdown;

interface BlockTypeInterface
{
    const PARAGRAPH = 0;
    const HEADER = 1;
    const SUBHEADER = 2;
    const LIST_ITEM = 3;
    const UNORDERED_LIST = 4;
}