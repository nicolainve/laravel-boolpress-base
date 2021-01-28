<?php

use Illuminate\Database\Seeder;
use App\Post;
use Illuminate\Support\Str;
use Faker\Generator as Faker;

class PostsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        for ($i = 0; $i < 10; $i++) {
            $title = $faker->text(50);
            $newPost = new Post;

            $newPost->title = $title;
            $newPost->body = $faker->paragraphs(2, true);
            $newPost->slug = Str::slug($title, '-');

            $newPost->save();
        }


        // $posts = [
        //     [
        //         'title' => 'nrcnrecrunnvrvnruvnruvnruvrn',
        //         'body' => 'cnrcnrcr'
        //     ],
        //     [
        //         'title' => 'sssss',
        //         'body' => 'cnrcnvvvrvrrcr'
        //     ],
        //     [
        //         'title' => 'vrvrvrv',
        //         'body' => 'cnrcxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxnrcr'
        //     ],
        // ];

        // foreach ($posts as $post) {

        //     $newPost = new Post;

        //     $newPost->title = $post['title'];
        //     $newPost->body = $post['body'];
        //     $newPost->slug = Str::slug($post['title'],'-');

        //     $newPost->save();
        // }
    }
}
