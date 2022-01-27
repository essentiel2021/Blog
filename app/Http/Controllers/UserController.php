<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except('profile');
    }
    public function profile(User $user){
        return 'Je suis ' . ' '. $user->name;
    }

    public function edit() //formulaire de mise à jour des infos du user connecté
    {
        $user = auth()->user();
        $data = [
            'title'=> $description = 'Editer mon prifil',
            'description' => $description,
            'user' => $user
        ];
        return view('user.edit',$data );
    }
    public function store() //sauvegarde des infos user
    {
        $user = auth()->user();
        request()->validate(
            [
                'name' =>['required','max:20', Rule::unique('users')->ignore($user)],
                'email' => ['required','email',Rule::unique('users')->ignore($user)],
                'avatar' => ['file','image','mimes:jpeg,png','sometimes','nullable']
            ]
            );
    }
}
