<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function owner()
    {
        return $this->user();
    }

    public function profile()
    {
        return $this->belongsTo('App\Profile');
    }

    public function path()
    {
        return '/tickets/' . $this->id;
    }

    public function interactions()
    {
        return $this->hasMany('App\Interaction')->latest();
    }

    public function addInteraction($attributes)
    {
        $this->permissionsToInteract();

        $this->update(['status' => 'Em aberto']);
        
        return $this->interactions()->create($attributes);
    }

    public function changeStatus($string)
    {
        $this->permissionsToChangeStatus();

        $this->update(['status' => $string]);
    }

    protected function isCompleted()
    {
        return $this->status === 'Concluído' ? true : false;
    }

    protected function isFinished()
    {
        return $this->status === 'Encerrado' ? true : false;
    }

    public function canInteract()
    {
        return $this->isCompleted() || $this->isFinished() && auth()->user()->isNot($this->owner) ? false : true;
    }

    protected function permissionsToInteract()
    {
        if($this->isCompleted())
            throw new \Exception('Não é possível adicionar uma nova interação à este chamado');
        elseif($this->isFinished() && auth()->user()->isNot($this->owner))
            abort(403);
    }

    protected function permissionsToChangeStatus()
    {
        if($this->status === 'Concluído')
            throw new \Exception('Não é possível alterar o status deste chamado');

        if($this->ownerTryingToFinish() || $this->nonOwnerTryingToClose())
            abort(403);
    }

    protected function ownerTryingToFinish()
    {
        return auth()->user()->is($this->owner) && request()->status === 'Encerrado' ? true : false;
    }

    protected function nonOwnerTryingToClose()
    {
        return auth()->user()->isNot($this->owner) && request()->status === 'Concluído' ? true : false;
    }
}
