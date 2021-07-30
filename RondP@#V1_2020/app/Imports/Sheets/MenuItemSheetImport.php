<?php

namespace App\Imports\Sheets;

use Harimayco\Menu\Models\MenuItems;
use Harimayco\Menu\Models\Menus;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\RegistersEventListeners;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\BeforeSheet;

class MenuItemSheetImport implements ToModel, WithEvents
{
    use Importable, RegistersEventListeners;

    public static function beforeSheet(BeforeSheet $event)
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        MenuItems::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }

    /**
     * @param array $row
     * @return MenuItems
     */
    public function model(array $row): MenuItems
    {
        $item             = new MenuItems();
        $item->id         = $row[0];
        $item->label      = $row[1];
        $item->link       = $row[2];
        $item->parent     = $row[3] == null ? '0' : $row[3];
        $item->sort       = $row[4] == null ? '0' : $row[4];
        $item->class      = $row[5];
        $item->menu       = $row[6];
        $item->depth      = $row[7] == null ? '0' : $row[7];
        $item->role_id    = $row[8] == null ? '0' : $row[8];
        $item->created_at = Carbon::create($row[9])->format('Y-m-d H:i:s');
        $item->updated_at = Carbon::create($row[10])->format('Y-m-d H:i:s');
        $item->save();
        return $item;
    }
}
