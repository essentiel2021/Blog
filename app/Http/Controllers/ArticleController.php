<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\ArticleRequest;

class ArticleController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except('index','show');
    }
    protected $perPage = 5;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $articles = Article::orderByDesc('id')->paginate($this->perPage);
       

        $data = [
            'title'=>'Les articles du blog - '.config('app.name'),
            'description'=>'Retrouvez tous les articles de '.config('app.name'),
            'articles'=>$articles,
        ];

        return view('article.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();
        $data = [
            'title' => $description = 'Ajouter un nouvel article',
            'description'=>$description,
            'categories'=>$categories,
        ];
        return view('article.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ArticleRequest $request)
    {
        $validatedData = $request->validated();
        $validatedData['category_id'] = request('category', null);
        Auth::user()->articles()->create($validatedData);

        // $article = Auth::user()->articles()->create(request()->validate(
        //     [
        //         'title' => ['required','unique:Articles,title','max:20'],
        //         'content' => ['required'],
        //         'category_id' => ['nullable','sometimes','exists:categories,id']
        //     ]
        // ));
       
        // $article = Article::create(request()->validate([
        //     'title' => ['required','unique:Articles,title','max:20'],
        //     'content' => ['required'],
        //     'category_id' => ['nullable','sometimes','exists:categories,id']
        // ]));

        //$article->category_id = request('category',null);
        // $article = new Article();
        // $article->user_id = auth()->id();
        // $article->category_id = request('category',null);
        // $article->title = request('title');
        // $article->slug = Str::slug($article->title);
        // $article->content = request('content');
        // $article->save();

        // Article::create([
        //     'user_id' => auth()->id(),
        //     'category_id' => request('category'),
        //     'title' => request('title'),
        //     'slug' => Str::slug(request('title')),
        //     'content' => request('content')
        // ]);

        $success = 'Article ajouté';

        return back()->withSuccess($success);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Article $article)
    {
        $data = [
            'title'=>$article->title.' - '.config('app.name'),
            'description'=>$article->title.'. '.Str::words($article->content, 10),
            'article'=>$article,
        ];
        return view('article.show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Article $article)
    {
        abort_if(Auth::user()->id != $article->user_id,403);
        $data = [
            'title'=> $description = 'Mise à jour de '.$article->title,
            'description'=>$description,
            'article'=>$article,
            'categories'=>Category::get(),
        ];

        return view('article.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ArticleRequest $request, Article $article)
    {
        abort_if(auth()->id() != $article->user_id, 403);

        $validatedData = $request->validated();
        $validatedData['category_id'] = request('category', null);

        $article = Auth::user()->articles()->updateOrCreate(['id'=>$article->id], $validatedData);

        $success = 'Article modifié';

        return redirect()->route('articles.edit', ['article'=>$article->slug])->withSuccess($success);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
