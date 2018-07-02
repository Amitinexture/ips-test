<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'contact_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
       
    public function modules(){
        return $this->belongsToMany('App\Module');
    }
    
    public function completed_modules()
    {
        return $this->belongsToMany('App\Module', 'user_completed_modules');
    }
    
    public function getByEmail($userEmail) {
        return User::where("email", $userEmail)->get()->first();
    }
   
    public function getLastCompletedModuleById($moduleIds) {
        $isCompleted = $this->completed_modules()->whereIn('module_id', $moduleIds)->count();

        if ($isCompleted > 0) {
            return $this->completed_modules()
                    ->whereIn('module_id', $moduleIds)
                    ->orderBy('display_sequence', 'desc')
                    ->limit(1)
                    ->first();
        }
        return null;
    }
    
    public function isAllModulesCompleted($lastModuleId)
    {
        return $this->completed_modules()->where('module_id', $lastModuleId)->count();
    }

}
