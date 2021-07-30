<?php

namespace App\Imports\Sheets;

use Harimayco\Menu\Models\MenuItems;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\RegistersEventListeners;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Database\Eloquent\Model;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\BeforeSheet;

class TermRelationshipSheetImport implements ToCollection, WithEvents
{
    use Importable, RegistersEventListeners;

    public static function beforeSheet(BeforeSheet $event)
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('term_relationships')->truncate();
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
            DB::table('term_relationships')->insert([
                'post_id'          => $row[0],
                'term_taxonomy_id' => $row[1],
                'created_at'       => Carbon::create($row[2])->format('Y-m-d H:i:s'),
                'updated_at'       => Carbon::create($row[3])->format('Y-m-d H:i:s'),
            ]);
        }
    }
}
