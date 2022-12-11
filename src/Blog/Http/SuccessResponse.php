<?php

namespace Tgu\Pakhomova\Blog\Http;

class SuccessResponse extends Response
{
    protected const SUCCESS = true;
    public function __construct(
        public array $data=[]
    )
    {
    }

    function payload(): array
    {
        return ['data'=>$this->data];
    }
}