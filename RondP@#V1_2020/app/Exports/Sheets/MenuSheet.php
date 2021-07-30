<?php

namespace App\Exports\Sheets;

use Harimayco\Menu\Models\Menus;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithTitle;

class MenuSheet implements FromCollection, WithTitle
{
    public function collection()
    {
        return Menus::all();
    }

    /**
     * @return string
     */
    public function title(): string
    {
        return 'Menu';
    }
}
