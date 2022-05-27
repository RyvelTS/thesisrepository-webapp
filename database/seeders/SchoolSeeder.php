<?php

namespace Database\Seeders;

use App\Models\School;
use Illuminate\Database\Seeder;

class SchoolSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    School::create([
      'name' => 'School of Oil and Natural Gas Engineering'
    ]);
    School::create([
      'name' => 'School of Computer Science'
    ]);
    School::create([
      'name' => 'School of Electronics and Information Engineering'
    ]);
    School::create([
      'name' => 'School of Civil Engineering and Architecture'
    ]);
    School::create([
      'name' => 'School of Mechanical Engineering'
    ]);
    School::create([
      'name' => 'School of Economics and Management / MBA'
    ]);
    School::create([
      'name' => 'School of Chemistry and Chemical Engineering'
    ]);
  }
}
