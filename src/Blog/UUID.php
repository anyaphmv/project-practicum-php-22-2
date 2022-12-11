<?php

namespace Tgu\Pakhomova\Blog;


use Tgu\Pakhomova\Blog\Exceptions\InvalidArgumentException;

class UUID
{
    public function __construct(private readonly string $uuid)
    {
        if (!uuid_is_valid($uuid)) {
            throw new InvalidArgumentException("Malformed UUID: $this->uuid");
        }
    }
    public function __toString(): string
    {
        return $this->uuid;
    }

    public static function random():self{
        return new self(uuid_create(UUID_TYPE_RANDOM));
    }
}