<?php

namespace App\CommonMark;

use App\CommonMark\Extension\Upto11BlocksExtension;
use League\CommonMark\CommonMarkConverter as BaseCommonMarkConverter;
use League\CommonMark\Environment;
use League\CommonMark\Extension\Attributes\AttributesExtension;
use League\CommonMark\Extension\GithubFlavoredMarkdownExtension;
use League\CommonMark\Extension\HeadingPermalink\HeadingPermalinkExtension;
use League\CommonMark\Extension\SmartPunct\SmartPunctExtension;
use League\CommonMark\Extension\Table\TableExtension;
use Tightenco\Collect\Support\Collection;

/**
 * @psalm-suppress DeprecatedInterface
 */
class CommonMarkConverter extends BaseCommonMarkConverter
{
    public function __construct(array $config = [])
    {
        $config['heading_permalink'] = ['insert' => 'after'];

        $environment = Environment::createCommonMarkEnvironment();

        $environment->addExtension(new AttributesExtension())
            ->addExtension(new GithubFlavoredMarkdownExtension())
            ->addExtension(new HeadingPermalinkExtension())
            ->addExtension(new SmartPunctExtension())
            ->addExtension(new TableExtension())
            ->addExtension(new Upto11BlocksExtension());

        parent::__construct($config, $environment);
    }
}
