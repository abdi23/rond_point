<?php

namespace App\Exports\Sheets;

use App\Models\User;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\FromCollection;

class UserSheet implements FromCollection, WithTitle
{
    public function collection()
    {
        return User::all();
    }

    /**
     * @return string
     */
    public function title(): string
    {
        return 'User';
    }
}
