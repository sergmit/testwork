<?php

use App\Models\Section;
use App\Models\UserSection;
use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Cache;

class SectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Cache::put('logos', []);
        factory(App\Models\Section::class, 15)->create();
        $usersAll = User::all();
        Section::all()->each(function($section) use($usersAll) {
            $users = $usersAll->random(random_int(0, 5));

            foreach($users as $user) {
                $userSection = new UserSection();
                $userSection->user_id = $user->id;
                $userSection->section_id = $section->id;
                $userSection->save();
            }
        });
    }
}
