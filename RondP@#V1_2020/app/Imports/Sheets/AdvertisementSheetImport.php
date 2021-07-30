<?php

namespace App\Imports\Sheets;

use App\Models\Advertisement;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\RegistersEventListeners;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\BeforeSheet;

class AdvertisementSheetImport implements ToModel, WithEvents
{
    use Importable, RegistersEventListeners;

    public static function beforeSheet(BeforeSheet $event)
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Advertisement::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }

    /**
     * @param array $row
     *
     * @return Advertisement
     */
    public function model(array $row)
    {
        return new Advertisement([
            'id'         => $row[0],
            'name'       => $row[1],
            'type'       => $row[2],
            'url'        => $row[3],
            'image'      => $row[4],
            'size'       => $row[5],
            'active'     => $row[6],
            'created_at' => $row[7],
            'updated_at' => $row[8]
        ]);
    }
}
