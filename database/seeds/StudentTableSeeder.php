<?php

use Illuminate\Database\Seeder;

class StudentTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('students')->insert([
        	['name'=>'Zhanshan','age'=>20],
        	['name'=>'Lisi','age'=>18],
        	['name'=>'Suli','age'=>19],
        	['name'=>'Goudan','age'=>21],
        	['name'=>'Tiedan','age'=>22]
        	]
        	);
    }
}
