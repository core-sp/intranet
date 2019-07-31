<?php

namespace App\Http\Controllers;

use App\User;
use App\Profile;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    public function index()
    {
        $this->authorize('view', User::class);

        $users = User::all();

        return view('users.index', compact('users'));
    }

    public function create()
    {
        $this->authorize('create', User::class);

        $profiles = Profile::select('id', 'name')->get();

        return view('users.create', compact('profiles'));
    }

    protected function validateRequest()
    {
        return request()->validate([
            'name' => 'required',
            'email' => 'required',
            'email_verified_at' => 'nullable',
            'is_admin' => 'boolean',
            'is_coordinator' => 'boolean',
            'profile_id' => 'integer',
            'password' => 'required'
        ]);
    }

    public function store(User $user)
    {
        $this->authorize('create', $user);

        $user->create($this->validateRequest());

        return redirect('/users')->with([
            'message' => 'Usuário criado com sucesso',
            'class' => 'alert-success'
        ]);
    }
}
