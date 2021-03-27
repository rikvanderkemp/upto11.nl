<?php
declare(strict_types=1);

namespace App\CommonMark\Parser;

use App\CommonMark\Extension\Upto11Block;
use League\CommonMark\Block\Parser\BlockParserInterface;
use League\CommonMark\ContextInterface;
use League\CommonMark\Cursor;
use League\CommonMark\Util\RegexHelper;

class Upto11BlocksParser implements BlockParserInterface
{
    public function parse(ContextInterface $context, Cursor $cursor): bool
    {
        if ($cursor->isIndented()) {
            return false;
        }

        $match = RegexHelper::matchAll(
            '/\[u11\:(.*)\]/',
            $cursor->getLine(),
            $cursor->getNextNonSpacePosition()
        );

        if (!$match) {
            return false;
        }

        $context->addBlock(new Upto11Block(trim($match[1])));
        $context->setBlocksParsed(true);

        return true;
    }
}
