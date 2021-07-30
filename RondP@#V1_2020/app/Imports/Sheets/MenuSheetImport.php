<?php

namespace App\Imports\Sheets;

use Harimayco\Menu\Facades\Menu;
use Harimayco\Menu\Models\Menus;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\RegistersEventListeners;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\BeforeSheet;

class MenuSheetImport implements ToModel, WithEvents
{
    use Importable, RegistersEventListeners;

    public static function beforeSheet(BeforeSheet $event)
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Menus::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }

    /**
     * @param array $row
     * @return Menus
     */
    public function model(array $row): Menus
    {
        $menu             = new Menus();
        $menu->id         = $row[0];
        $menu->name       = $row[1];
        $menu->created_at = Carbon::create($row[2])->format('Y-m-d H:i:s');
        $menu->updated_at = Carbon::create($row[3])->format('Y-m-d H:i:s');
        $menu->save();
        return $menu;
    }
}
