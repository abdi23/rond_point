<?php

namespace App\Imports\Sheets;

use App\Models\AdPlacement;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\RegistersEventListeners;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\BeforeSheet;

class AdPlacementSheetImport implements ToModel, WithEvents
{
    use Importable, RegistersEventListeners;

    public static function beforeSheet(BeforeSheet $event)
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        AdPlacement::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }

    /**
     * @param array $row
     *
     * @return AdPlacement
     */
    public function model(array $row)
    {
        return new AdPlacement([
            'id'         => $row[0],
            'name'       => $row[1],
            'slug'       => $row[2],
            'active'     => $row[3] == null ? 'y' : $row[3],
            'created_at' => $row[4],
            'updated_at' => $row[5],
        ]);
    }
}
