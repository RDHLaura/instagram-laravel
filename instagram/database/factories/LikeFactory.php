<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use \App\Models\User;
use \App\Models\Image;
use \App\Models\Like;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Like>
 */
class LikeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $user_id = User::all()->random(1)->first()->id;
        $image_id = Image::all()->random(1)->first()->id;
        //evitar crear likes duplicados:
        while( Like::where('user_id',$user_id)->where('image_id',$image_id)->exists() ) {
            $image_id = Image::all()->random(1)->first()->id;
        }
        return [
            'user_id' => $user_id,
            'image_id' => $image_id,
            "created_at" => now(),
             
        ];
    }
}
