<?php

namespace App\Exports\Sheets;

use Harimayco\Menu\Models\MenuItems;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithTitle;

class MenuItemSheet implements FromCollection, WithTitle
{
    public function collection()
    {
        return MenuItems::all();
    }

    /**
     * @return string
     */
    public function title(): string
    {
        return 'Menu Item';
    }
}
