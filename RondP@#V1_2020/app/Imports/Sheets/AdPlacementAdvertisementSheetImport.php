<?php

namespace App\Imports\Sheets;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\RegistersEventListeners;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Database\Eloquent\Model;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\BeforeSheet;

class AdPlacementAdvertisementSheetImport implements ToCollection, WithEvents
{
    use Importable, RegistersEventListeners;

    public static function beforeSheet(BeforeSheet $event)
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('ad_placement_advertisement')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }

    /**
     * @param Collection $rows
     * @return Model|null
     */
    public function collection(Collection $rows)
    {
        foreach($rows as $row)
        {
            DB::table('ad_placement_advertisement')->insert([
                'advertisement_id' => $row[0],
                'ad_placement_id'  => $row[1],
            ]);
        }
    }
}
