<?php

namespace Tgu\Pakhomova\Blog\Http\Actions;

use Tgu\Pakhomova\Blog\Http\Request;
use Tgu\Pakhomova\Blog\Http\Response;

interface ActionInterface
{
public function handle(Request $request):Response;
}
