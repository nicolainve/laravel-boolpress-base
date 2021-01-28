<?php

use Illuminate\Database\Seeder;
use App\Post;
use App\Comment;
use Faker\Generator as Faker;

class CommentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        $posts = Post::all();

        for ($i = 0; $i < 3; $i++) {
            foreach ($posts as $post) {
                $newComment = new Comment();
    
                $newComment->post_id = $post->id;
                $newComment->author = $faker->userName();
                $newComment->text = $faker->sentence(10);
    
                $newComment->save();
            }
        }
    }
}
