<?php

declare(strict_types=1);

namespace App\Markdown;

interface BlockTypeInterface
{
    public const PARAGRAPH = 0;
    public const HEADER = 1;
    public const SUBHEADER = 2;
    public const LIST_ITEM = 3;
    public const UNORDERED_LIST = 4;
}
