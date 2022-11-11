<?php

namespace Tgu\Pakhomova\Blog;

class Post
{
    public function __construct(
        private UUID $id,
        private string $id_author,
        private string $header,
        private string $text,
    )
    {
    }

    public function __toString(): string
    {
        $id=$this->getUuidPost();
        return "Post $id author $this->id_author with title $this->header and text - $this->text".PHP_EOL;
    }
    public function getUuidPost():UUID{
        return $this->id;
    }
    public function getUuidUser():string{
        return $this->id_author;
    }
    public function getTitle():string{
        return $this->header;
    }
    public function getTextPost():string{
        return $this->text;
    }


}