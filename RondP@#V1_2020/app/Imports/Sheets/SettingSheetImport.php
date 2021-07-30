<?php

namespace App\Imports\Sheets;

use App\Models\Setting;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\RegistersEventListeners;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\BeforeSheet;

class SettingSheetImport implements ToModel, WithEvents
{
    use Importable, RegistersEventListeners;

    public static function beforeSheet(BeforeSheet $event)
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Setting::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }

    /**
     * @param array $row
     *
     * @return Model|null
     */
    public function model(array $row)
    {
        return new Setting([
            'id'         => $row[0],
            'group'      => $row[1],
            'name'       => $row[2],
            'value'      => $row[3],
            'created_at' => $row[4],
            'updated_at' => $row[5],
        ]);
    }
}
