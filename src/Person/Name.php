<?php

namespace Tgu\Pakhomova\Person;

class Name
{
    public function __construct(
        public int $id,
        private string $firstname,
        private string $lastname,
    )
    {
    }

    public function __toString(): string
    {
        return $this->id . ' - код пользователя, ' . $this->firstname . ' - имя, ' . $this->lastname . ' - фамилия!';
    }

}