<?php

namespace Tgu\Pakhomova\Blog;

class Comments
{
    public function __construct(
    private int $id,
    private int $id_author,
    private int $id_post,
    private string $text,
)
{
}

    public function __toString(): string
    {
        return $this->id . ' - код комментария, ' .$this->id_author . ' - автор, ' .$this->id_post . ' - статья, а далее комментарий: ' . $this->text;
    }

}