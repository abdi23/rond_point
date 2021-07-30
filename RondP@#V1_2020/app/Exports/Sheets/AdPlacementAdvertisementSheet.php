<?php

namespace App\Exports\Sheets;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithTitle;

class AdPlacementAdvertisementSheet implements FromCollection, WithTitle
{
    public function collection()
    {
        return DB::table('ad_placement_advertisement')->get();
    }

    /**
     * @return string
     */
    public function title(): string
    {
        return 'Ad Placement Advertisement';
    }
}
