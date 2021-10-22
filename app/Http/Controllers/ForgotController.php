<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Notifications\PasswordResetNotification;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ForgotController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest');
    }
    
    public function index() //affichage du formulaire de reunitialisation de mot de passe 
    {
        $data = [
    		'title'=> $description = 'Oublie de mot de passe - '.config('app.name'),
    		'description'=>$description,
    	];

    	return view('auth.forgot', $data);
    }
    public function store() // verification des data et envoie du lien par mail
    {
        request()->validate([
            'email'=>['required','email','exists:users']
        ]);
        $token = Str::uuid();
        DB::table('password_resets')->insert(
            [
                'email' => request('email'),
                'token' => $token,
                'created_at' => now()
            ]
        );
        $user = User::whereEmail(request('email'))->firstOrFail();
        $user->notify(new PasswordResetNotification($token));
        $success = 'Vérifier votre boîte mail et suivez les instructions.';
    	return back()->withSuccess($success);
    }
}
