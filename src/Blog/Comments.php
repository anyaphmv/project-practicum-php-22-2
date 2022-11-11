<?php

namespace Tgu\Pakhomova\Blog;

class Comments
{
    public function __construct(
    private UUID $idCom,
    private string $id_post,
    private string $id_author,
    private string $textCom,
)
{
}

    public function __toString(): string
    {
        $idCom=$this->getUuidComment();
        return "Comment $idCom with post $this->id_post where author $this->id_author  and text - $this->textCom".PHP_EOL;
    }
    public function getUuidComment():UUID{
        return $this->idCom;
    }
    public function getUuidPost():string{
        return $this->id_post;
    }
    public function getUuidUser():string{
        return $this->id_author;
    }
    public function getTextComment():string{
        return $this->textCom;
    }

}