<?php

namespace Tgu\Pakhomova\Blog;

class Post
{
    public function __construct(
        public int $id,
        private int $id_author,
        private string $header,
        private string $text,
    )
    {
    }

    public function __toString(): string
    {
        return $this->id . ' - номер статьи, ' .$this->id_author . ' - автор, ' .$this->header . ' - заголовок, а далее текст: ' . $this->text;
    }


}