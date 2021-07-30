<?php

namespace App\Exports\Sheets;

use App\Models\Advertisement;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithTitle;

class AdvertisementSheet implements FromCollection, WithTitle
{
    public function collection()
    {
        return Advertisement::all();
    }

    /**
     * @return string
     */
    public function title(): string
    {
        return 'Advertisement';
    }
}
