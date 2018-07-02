<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Module extends Model {

    //
    protected $table = 'modules';

    public function users() {
        return $this->belongsToMany('App\User');
    }

    public function tags() {
        return $this->belongsToMany('App\Tags', 'modules_tags_mapping');
    }

    public function getModuleByCourseKey($coursekey) {
        return Module::where('course_key', $coursekey)->orderBy('display_sequence')->get();
    }

    public function getNextModuleById($moduleId) {
        $isThereModule = Module::where([['id', '>', $moduleId], ['display_sequence', '<=', 7]])
                ->orderBy('display_sequence')
                ->count();

        if ($isThereModule > 0) {
            return Module::with('tags')
                            ->where([['id', '>', $moduleId], ['display_sequence', '<=', 7]])
                            ->orderBy('display_sequence')
                            ->limit(1)
                            ->first();
        }
        return null;
    }

    public function getLastModuleId() {
        return Module::orderBy('id', 'desc')
                ->limit(1)
                ->select('id')
                ->get();
    }
}
