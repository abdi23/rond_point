<?php

namespace App\Imports\Sheets;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\RegistersEventListeners;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\BeforeSheet;
use Spatie\Permission\Models\Role;
use Illuminate\Database\Eloquent\Model;
use Maatwebsite\Excel\Concerns\ToModel;

class RoleSheetImport implements ToModel, WithEvents
{
    use Importable, RegistersEventListeners;

    public static function beforeSheet(BeforeSheet $event)
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Role::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }

    /**
     * @param array $row
     *
     * @return Model|null
     */
    public function model(array $row)
    {
        return new Role([
            'id'         => $row[0],
            'name'       => $row[1],
            'guard_name' => $row[2],
            'created_at' => $row[3],
            'updated_at' => $row[4],
        ]);
    }
}
