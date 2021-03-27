<?php
declare(strict_types=1);

namespace App\Parser;

use App\Document\FrontMatterDocument;
use Symfony\Component\Yaml\Yaml;

class FrontMatterParser
{
    public function parse(string $content): FrontMatterDocument
    {
        $pattern = '/^[\s\r\n]?---[\s\r\n]?$/m';

        $split = preg_split($pattern, PHP_EOL . ltrim($content));

        if (count($split) < 3) {
            return new FrontMatterDocument([], $content);
        }

        $properties = Yaml::parse(trim($split[1]));

        $body = trim(implode('', array_slice($split, 2)), PHP_EOL);

        return new FrontMatterDocument($properties, $body);
    }
}
