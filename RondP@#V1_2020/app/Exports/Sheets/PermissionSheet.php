<?php

namespace App\Exports\Sheets;

use Spatie\Permission\Models\Permission;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithTitle;

class PermissionSheet implements FromCollection, WithTitle
{
    public function collection()
    {
        return Permission::all();
    }

    /**
     * @return string
     */
    public function title(): string
    {
        return 'Permission';
    }
}
