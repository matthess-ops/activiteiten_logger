<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;


class PostsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $currentTime =Carbon::now();
        for ($i=0200; $i <200 ; $i++) { 
            $currentTime->addMinutes(10);

            DB::table('posts')->insert([
                'created_at'=>$currentTime,
                'updated_at'=>$currentTime,
                'title'=>"title".$i,
                'post'=>"content .$i.asdfadfasdfasdfasdfasdfsasdfasdfadfafasdfasdofkaspdfkas odkfoasdkfoa skdfoas d foas dfpoasdjpfjasodfjspo jf aposfepoadf"
                
    
            ]);       
        }
     
    }
}
