<?php

namespace App\Exports\Sheets;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\FromCollection;

class UserSocialmediaSheet implements FromCollection, WithTitle
{
    public function collection()
    {
        return DB::table('user_socialmedia')->get();
    }

    /**
     * @return string
     */
    public function title(): string
    {
        return 'User Socialmedia';
    }
}
