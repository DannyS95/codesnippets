<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Transformers\Snippets\SnippetTransformer;
use App\Models\User;

class SnippetController extends Controller
{
    public function index(User $user){
        return fractal()
        ->collection(
            $user->snippets()->public()->get()
        )
        ->transformWith(new SnippetTransformer())
        ->toArray();
    }
}
