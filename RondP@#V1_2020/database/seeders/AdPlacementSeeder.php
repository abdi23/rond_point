<?php

namespace Database\Seeders;

use App\Models\AdPlacement;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class AdPlacementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        AdPlacement::create([
            'name'   => 'sidebar-right-top',
            'slug'   => 'sidebar-right-top',
            'active' => 'y'
        ])->ad()->sync([1]);

        AdPlacement::create([
            'name'   => 'sidebar-right-bottom',
            'slug'   => 'sidebar-right-bottom',
            'active' => 'y'
        ])->ad()->sync([1]);

        AdPlacement::create([
            'name'   => 'sidebar-left-top',
            'slug'   => 'sidebar-left-top',
            'active' => 'y'
        ])->ad()->sync([1]);

        AdPlacement::create([
            'name'   => 'sidebar-left-bottom',
            'slug'   => 'sidebar-left-bottom',
            'active' => 'y'
        ])->ad()->sync([1]);

        AdPlacement::create([
            'name'   => 'home-horizontal',
            'slug'   => 'home-horizontal',
            'active' => 'y'
        ])->ad()->sync([2]);
    }
}
