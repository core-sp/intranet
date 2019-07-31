<?php

namespace App\Http\Controllers;

use App\Profile;
use Illuminate\Http\Request;

class ProfilesController extends Controller
{
    public function index()
    {
        $profiles = Profile::all();

        return view('profiles.index', compact('profiles'));
    }

    public function create(Profile $profile)
    {
        $this->authorize('create', $profile);

        return view('profiles.create');
    }

    public function validateRequest()
    {   
        return request()->validate([
            'name' => 'required',
        ]);
    }

    public function store(Profile $profile)
    {
        $this->authorize('create', $profile);

        $profile->create($this->validateRequest());

        return redirect('/profiles')->with([
            'message' => 'Perfil criado com sucesso',
            'class' => 'alert-success'
        ]);
    }
}