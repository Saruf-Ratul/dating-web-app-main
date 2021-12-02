<?php

use App\Like;
use Illuminate\Database\Seeder;

class LikesTableSeeder extends Seeder
{
    public function run()
    {
        $records = [
            [ 'user_id' => 1,'target_user_id'=>2,'like_status'=>1 ],
            [ 'user_id' => 1,'target_user_id'=>3,'like_status'=>1 ],
            [ 'user_id' => 1,'target_user_id'=>4,'like_status'=>1 ],
        ];
        Like::insert($records);
    }
}
