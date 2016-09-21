<?php

use Illuminate\Database\Seeder;

class DepartmentTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      DB::table('departments')->delete();

      $departments = [
        ['id' => 1, 'department' => '護理系所', 'created_at' => new DateTime, 'updated_at' => new DateTime],
        ['id' => 2, 'department' => '資訊管理系所', 'created_at' => new DateTime, 'updated_at' => new DateTime],
        ['id' => 3, 'department' => '長期照護系所', 'created_at' => new DateTime, 'updated_at' => new DateTime],
        ['id' => 4, 'department' => '運動保健系所', 'created_at' => new DateTime, 'updated_at' => new DateTime],
        ['id' => 5, 'department' => '嬰幼兒保育系所', 'created_at' => new DateTime, 'updated_at' => new DateTime],
        ['id' => 6, 'department' => '健康事業管理系所', 'created_at' => new DateTime, 'updated_at' => new DateTime],
        ['id' => 7, 'department' => '語言治療與聽力學系', 'created_at' => new DateTime, 'updated_at' => new DateTime],
        ['id' => 8, 'department' => '休閒產業與健康促進系所', 'created_at' => new DateTime, 'updated_at' => new DateTime],
        ['id' => 9, 'department' => '生死與健康心理諮商系所', 'created_at' => new DateTime, 'updated_at' => new DateTime],
      ];

      DB::table('departments')->insert($departments);

    }
}
