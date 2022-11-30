<?php

namespace Tgu\Pakhomova\Person;

class Name
{
    public function __construct(
        private string $firstname,
        private string $lastname,
    )
    {
    }

    public function __toString(): string
    {
        return $this->firstname . ' - имя, ' . $this->lastname . ' - фамилия!';
    }
    public function getFirstName():string{
        return $this->firstname;
    }
    public function getLastName():string{
        return $this->lastname;
    }

}