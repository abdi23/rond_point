<?php

namespace App\Imports\Sheets;

use App\Models\Socialmedia;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\RegistersEventListeners;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\BeforeSheet;

class SocialmediaSheetImport implements ToModel, WithEvents
{
    use Importable, RegistersEventListeners;

    public static function beforeSheet(BeforeSheet $event)
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Socialmedia::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }

    /**
     * @param array $row
     *
     * @return Model|null
     */
    public function model(array $row)
    {
        return new Socialmedia([
            'id'         => $row[0],
            'name'       => $row[1],
            'slug'       => $row[2],
            'url'        => $row[3],
            'icon'       => $row[4],
            'created_at' => $row[5],
            'updated_at' => $row[6],
        ]);
    }
}
