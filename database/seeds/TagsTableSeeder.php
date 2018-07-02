<?php

use Illuminate\Database\Seeder;
use App\Http\Helpers\InfusionsoftHelper;
use App\Tags;

class TagsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $infusionsoft = new InfusionsoftHelper();
        $tags = $infusionsoft->getAllTags();
        $tagsCount = count($tags);
        
        for($index = 0; $index < $tagsCount; $index++) {
            Tags::insert([
                "tags_id" => $tags[$index]->id,
                "name" => $tags[$index]->name,
                "description" => $tags[$index]->description,
                "category" => $tags[$index]->category,
            ]);
        }
    }
}
