<?php

use Illuminate\Database\Seeder;
use Faker\Generator as Faker;
use App\Post;
use App\InfoPost;

class InfoPostsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        $posts = Post::all();

        foreach ($posts as $post) {
            $newInfo = new InfoPost();

            $newInfo->post_id = $post->id;
            $newInfo->post_status = $faker->randomElement(['public', 'private', 'draft']);
            $newInfo->comment_status = $faker->randomElement(['open', 'closed', 'private']);

            $newInfo->save();
        }
    }
}
