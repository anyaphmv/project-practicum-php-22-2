<?php

namespace TGU\Pakhomova\PhpUnit\Blog\Container;

class ComeClassDependingOnAnother
{
public function __construct(
    SomeClassWithoutDependencies $one,
    SomeClassWithParameter $two
)
{

}
}