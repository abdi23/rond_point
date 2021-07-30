<?php

namespace App\Exports\Sheets;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithTitle;

class RoleHasPermissionSheet implements FromCollection, WithTitle
{
    public function collection()
    {
        return DB::table('role_has_permissions')->get();
    }

    /**
     * @return string
     */
    public function title(): string
    {
        return 'Role has permissions';
    }
}
