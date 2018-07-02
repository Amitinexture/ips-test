<?php

use Illuminate\Database\Seeder;
use App\Tags;
use App\Module;

class ModuleTagsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //IPA Course
        $moduleTag = Module::where('id', 1)->first();        
        $moduleTag->tags()->attach(Tags::where('tags_id', '=', 110)->get());
        
        $moduleTag = Module::where('id', 4)->first();        
        $moduleTag->tags()->attach(Tags::where('tags_id', '=', 112)->get());
        
        $moduleTag = Module::where('id', 7)->first();        
        $moduleTag->tags()->attach(Tags::where('tags_id', '=', 114)->get());
        
        $moduleTag = Module::where('id', 10)->first();        
        $moduleTag->tags()->attach(Tags::where('tags_id', '=', 116)->get());
        
        $moduleTag = Module::where('id', 13)->first();        
        $moduleTag->tags()->attach(Tags::where('tags_id', '=', 118)->get());
        
        $moduleTag = Module::where('id', 16)->first();        
        $moduleTag->tags()->attach(Tags::where('tags_id', '=', 120)->get());
        
        $moduleTag = Module::where('id', 19)->first();        
        $moduleTag->tags()->attach(Tags::where('tags_id', '=', 122)->get());
        
        //IEA
        $moduleTag = Module::where('id', 2)->first();        
        $moduleTag->tags()->attach(Tags::where('tags_id', '=', 124)->get());
        
        $moduleTag = Module::where('id', 5)->first();        
        $moduleTag->tags()->attach(Tags::where('tags_id', '=', 126)->get());
        
        $moduleTag = Module::where('id', 8)->first();        
        $moduleTag->tags()->attach(Tags::where('tags_id', '=', 128)->get());
        
        $moduleTag = Module::where('id', 11)->first();        
        $moduleTag->tags()->attach(Tags::where('tags_id', '=', 130)->get());
        
        $moduleTag = Module::where('id', 14)->first();        
        $moduleTag->tags()->attach(Tags::where('tags_id', '=', 132)->get());
        
        $moduleTag = Module::where('id', 17)->first();        
        $moduleTag->tags()->attach(Tags::where('tags_id', '=', 134)->get());
        
        $moduleTag = Module::where('id', 20)->first();        
        $moduleTag->tags()->attach(Tags::where('tags_id', '=', 136)->get());
        
        //IAA 
        $moduleTag = Module::where('id', 3)->first();        
        $moduleTag->tags()->attach(Tags::where('tags_id', '=', 138)->get());
        
        $moduleTag = Module::where('id', 6)->first();        
        $moduleTag->tags()->attach(Tags::where('tags_id', '=', 140)->get());
        
        $moduleTag = Module::where('id', 9)->first();        
        $moduleTag->tags()->attach(Tags::where('tags_id', '=', 142)->get());
        
        $moduleTag = Module::where('id', 12)->first();        
        $moduleTag->tags()->attach(Tags::where('tags_id', '=', 144)->get());
        
        $moduleTag = Module::where('id', 15)->first();        
        $moduleTag->tags()->attach(Tags::where('tags_id', '=', 146)->get());
        
        $moduleTag = Module::where('id', 18)->first();        
        $moduleTag->tags()->attach(Tags::where('tags_id', '=', 148)->get());
        
        $moduleTag = Module::where('id', 21)->first();        
        $moduleTag->tags()->attach(Tags::where('tags_id', '=', 150)->get());
    }
}
