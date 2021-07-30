<?php

namespace App\Imports\Sheets;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Database\Eloquent\Model;

class UserSocialmediaSheetImport implements ToCollection
{
    /**
     * @param Collection $rows
     * @return Model|null
     */
    public function collection(Collection $rows)
    {
        foreach($rows as $row)
        {
            DB::table('user_socialmedia')->upsert([
                'id'             => $row[0],
                'user_id'        => $row[1],
                'socialmedia_id' => $row[2],
                'url'            => $row[3],
                'created_at'     => $row[4],
                'updated_at'     => $row[5]
            ],
            ['id', 'user_id', 'socialmedia_id', 'url', 'created_at', 'updated_at'],
            ['id', 'user_id', 'socialmedia_id', 'url', 'created_at', 'updated_at']);
        }
    }
}
