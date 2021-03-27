<?php

namespace App\Document;

use Symfony\Component\PropertyAccess\PropertyAccess;

class FrontMatterProperties
{
    private string $title;
    private ?string $slug = null;
    private string $template = 'article';
    private string $type = 'default';
    private string $synopsis = '';

    public function __construct(array $array)
    {
        $propertyAccessor = PropertyAccess::createPropertyAccessor();

        foreach ($array as $key => $value) {
            if (!$propertyAccessor->isWritable($this, $key)) {
                continue;
            }
            $propertyAccessor->setValue($this, $key, $value);
        }
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): FrontMatterProperties
    {
        $this->title = $title;
        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(?string $slug): FrontMatterProperties
    {
        $this->slug = $slug;
        return $this;
    }

    public function setTemplate(string $template): FrontMatterProperties
    {
        $this->template = $template;
        return $this;
    }

    public function getTemplate(): string
    {
        return $this->template;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function setType(string $type): FrontMatterProperties
    {
        $this->type = $type;

        return $this;
    }

    public function getSynopsis(): string
    {
        return $this->synopsis;
    }

    public function setSynopsis(string $synopsis): FrontMatterProperties
    {
        $this->synopsis = $synopsis;
        return $this;
    }

    public function toArray(): array
    {
        $propertyAccessor = PropertyAccess::createPropertyAccessor();

        $properties = [];

        $reflection = new \ReflectionClass($this);

        foreach ($reflection->getProperties() as $property) {
            $propertyPath = $property->getName();
            $properties[$propertyPath] = $propertyAccessor->getValue($this, $propertyPath);
        }

        return $properties;
    }
}
