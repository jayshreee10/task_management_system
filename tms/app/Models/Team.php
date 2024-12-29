<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;

class Team extends Model
{

    protected $fillable = ['name', 'description', 'members', 'leads'];


    protected $casts = [
        'members' => 'array',
        'leads' => 'array',
    ];


    public function users()
    {
        return $this->belongsToMany(User::class);
    }


    public function tasks()
    {
        return $this->hasMany(Task::class);
    }



    public function leads()
    {
        return $this->belongsToMany(User::class, 'team_user', 'team_id', 'user_id')
                    ->wherePivot('is_lead', true);
    }

    public function scopeAssignedToUser($query, $user)
    {
        return $query->whereHas('users', function($q) use ($user) {
            $q->where('users.id', $user->id);
        });
    }



    public function addMembers(array $userIds)
    {

        $this->members = array_unique(array_merge($this->members ?? [], $userIds));
        $this->save();
    }


    public function addLeads(array $userIds)
    {

        $this->leads = array_unique(array_merge($this->leads ?? [], $userIds));
        $this->save();
    }


    public function removeMembers(array $userIds)
    {

        $this->members = array_diff($this->members ?? [], $userIds);
        $this->save();
    }


    public function removeLeads(array $userIds)
    {

        $this->leads = array_diff($this->leads ?? [], $userIds);
        $this->save();
    }
}
