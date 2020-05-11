<?php

/** @var Factory $factory */

use App\Models\Section;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

$factory->define(Section::class, function (Faker $faker) {
    $logos = Storage::disk('local')->files('logo');
    $used_logos = Cache::get('logos', []);
    $cnt = 0;
    $logo = null;
    do {
        $cnt++;
        $logo = $logos[array_rand($logos)];
        if (in_array($logo, $used_logos, true)) {
            $logo = null;
        } else {
            $used_logos[] = $logo;
            Cache::put('logos', $used_logos, 100);
        }
    } while (empty($logo) && $cnt < 100);

    return [
        'name' => $faker->company,
        'description' => $faker->text(200),
        'logo' => asset($logo)
    ];
});
