<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tags extends Model
{
    //
    protected $table = 'tags';
    
    public function modules(){
        return $this->belongsToMany('App\Module', 'modules_tags_mapping');
    }
}
