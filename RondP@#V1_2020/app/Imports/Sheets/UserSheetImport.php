<?php

namespace App\Imports\Sheets;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\RegistersEventListeners;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\BeforeSheet;

class UserSheetImport implements ToModel, WithEvents
{
    use Importable, RegistersEventListeners;

    public static function beforeSheet(BeforeSheet $event)
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        User::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }

    /**
     * @param array $row
     *
     * @return Model|null
     */
    public function model(array $row)
    {
        return new User([
            'id'                => $row[0],
            'name'              => $row[1],
            'email'             => $row[2],
            'email_verified_at' => $row[3],
            'username'          => $row[4],
            'password'          => $row[5],
            'photo'             => $row[6],
            'occupation'        => $row[7],
            'about'             => $row[8],
            'remember_token'    => $row[9],
            'created_at'        => $row[10],
            'updated_at'        => $row[11],
        ]);
    }
}
