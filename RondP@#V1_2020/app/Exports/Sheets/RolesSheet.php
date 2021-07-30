<?php

namespace App\Exports\Sheets;

use Maatwebsite\Excel\Concerns\WithTitle;
use Spatie\Permission\Models\Role;
use Maatwebsite\Excel\Concerns\FromCollection;

class RolesSheet implements FromCollection, WithTitle
{
    public function collection()
    {
        return Role::all();
    }

    /**
     * @return string
     */
    public function title(): string
    {
        return 'Role';
    }
}
