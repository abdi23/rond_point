<?php

namespace App\Exports\Sheets;

use App\Models\AdPlacement;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithTitle;

class AdPlacementSheet implements FromCollection, WithTitle
{
    public function collection()
    {
        return AdPlacement::all();
    }

    /**
     * @return string
     */
    public function title(): string
    {
        return 'Ad Placement';
    }
}
