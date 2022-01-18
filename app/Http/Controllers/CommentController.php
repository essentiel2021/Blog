<?php

namespace App\Http\Controllers;

use App\Events\CommentWasCreated;
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

        $comment = $article->comments()->create($validatedData);
        if(auth()->id() != $article->user_id)//si le commentateur n'est pas l'auteur del'article
        {
           event(new CommentWasCreated($comment));
        }

        $success = 'commentaire ajouté.';

        return back()->withSuccess($success);
    }
}
