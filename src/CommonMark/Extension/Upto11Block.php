<?php
declare(strict_types=1);

namespace App\CommonMark\Extension;

use League\CommonMark\Block\Element\AbstractBlock;
use League\CommonMark\Cursor;

class Upto11Block extends AbstractBlock
{
    private string $type;

    public function __construct(string $type)
    {
        $this->type = $type;
    }

    public function canContain(AbstractBlock $block): bool
    {
        return true;
    }

    public function isCode(): bool
    {
        return false;
    }

    public function matchesNextLine(Cursor $cursor): bool
    {
        return false;
    }

    public function getType(): string
    {
        return $this->type;
    }
}
