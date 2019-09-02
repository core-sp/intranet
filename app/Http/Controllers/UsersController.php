<?php

namespace App\Http\Controllers;

use App\User;
use App\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller
{
    public function index()
    {
        $this->authorize('view', User::class);

        $users = User::paginate(20);

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
            'username' => 'required',
            'email_verified_at' => 'nullable',
            'is_admin' => 'boolean',
            'is_coordinator' => 'boolean',
            'profile_id' => 'integer',
            'password' => 'min:6|confirmed',
        ], [
            'required' => 'O campo :attribute é obrigatório'
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

    protected function confirmAuthenticity($user)
    {
        auth()->id() !== $user->id ? abort(403) : true;
    }

    protected function authorizeUpdate($user)
    {
        if(auth()->user()->isAdmin()) {
            return $this->authorize('updateOther', $user);
        }
        
        $this->confirmAuthenticity($user);
    }

    public function edit(User $user)
    {
        $this->authorizeUpdate($user);

        $profiles = Profile::select('id', 'name')->get();
        
        return view('users.edit', compact('user', 'profiles'));
    }

    public function update(User $user)
    {
        $this->authorizeUpdate($user);

        $user->update(request()->all());

        return redirect('/')->with([
            'message' => 'Informações atualizadas com sucesso',
            'class' => 'alert-success'
        ]);
    }

    protected function userOrAdmin($id)
    {
        if(auth()->id() === $id || auth()->user()->isAdmin())
            return true;
        
        abort(403, 'Olá');
    }

    public function changePasswordView(User $user)
    {
        $this->userOrAdmin($user->id);

        return view('users.change-password');
    }

    public function changePassword(User $user)
    {
        $this->userOrAdmin($user->id);

        $user->fill(['password' => request('password')])->save();

        return redirect('/')->with([
            'message' => 'Senha alterada com sucesso',
            'class' => 'alert-success'
        ]);
    }

    public function destroy(User $user)
    {
        $this->authorize('view', $user);

        $user->delete();

        return redirect('/')->with([
            'message' => 'Usuário deletado com sucesso',
            'class' => 'alert-success'
        ]);
    }
}
