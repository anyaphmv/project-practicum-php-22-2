<?php

namespace Person;

use DateTimeImmutable;
use Tgu\Pakhomova\Person\Name;

class Person
{
public function __construct(
    private Name $name,
    private DateTimeImmutable $registeredOn
)
{
}
public function __toString(): string
{
    return $this->name.' on site with '.$this->registeredOn->format('Y-m-d');
}
}