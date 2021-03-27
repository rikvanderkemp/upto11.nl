<?php

namespace App\Controller;

use App\Document\FrontMatterProperties;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class PageController extends AbstractController
{
    public function __invoke(string $slug, string $file, array $properties = []): Response
    {
        $frontMatterProperties = new FrontMatterProperties($properties);

        return $this->render(
            "page/{$frontMatterProperties->getTemplate()}.html.twig",
            [
                'content' => file_get_contents($file),
                'properties' => $frontMatterProperties,
            ]
        );
    }
}
