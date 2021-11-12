<?php

namespace App\Http\Controllers;

use App\Http\Requests\commentRequest;
use App\Models\Article;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function store( commentRequest $request, Article $article)
    {
        $validatedData = $request->validated();
        $validatedData['user_id'] = auth()->id();

        $article->comments()->create($validatedData);
        if(auth()->id() != $article->user_id)//si le commentateur n'est pas l'auteur del'article
        {
            dd($article->user());
        }

        $success = 'commentaire ajouté.';

        return back()->withSuccess($success);
    }
}
