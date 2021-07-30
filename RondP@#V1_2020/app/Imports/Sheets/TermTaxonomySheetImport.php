<?php

namespace App\Imports\Sheets;

use App\Models\TermTaxonomy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\RegistersEventListeners;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\BeforeSheet;

class TermTaxonomySheetImport implements ToModel, WithEvents
{
    use Importable, RegistersEventListeners;

    public static function beforeSheet(BeforeSheet $event)
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        TermTaxonomy::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }

    /**
     * @param array $row
     *
     * @return Model|null
     */
    public function model(array $row)
    {
        return new TermTaxonomy([
            'id'          => $row[0],
            'term_id'     => $row[1],
            'taxonomy'    => $row[2],
            'description' => $row[3],
            'parent'      => $row[4],
            'count'       => $row[5],
            'created_at'  => $row[6],
            'updated_at'  => $row[7],
        ]);
    }
}
