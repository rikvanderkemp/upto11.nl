<?php

namespace App\Document;

class FrontMatterDocument
{
    private FrontMatterProperties $properties;
    private string $body;
    private string $uri;

    public function __construct(array $properties, string $body)
    {
        $this->properties = new FrontMatterProperties($properties);
        $this->body = $body;
    }

    public function getProperties(): FrontMatterProperties
    {
        return $this->properties;
    }

    public function getBody(): string
    {
        return $this->body;
    }

    public function setUri(string $uri): void
    {
        $this->uri = $uri;
    }

    public function getUri(): string
    {
        return $this->uri;
    }
}
