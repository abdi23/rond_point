<?php

namespace App\Exports\Sheets;

use App\Models\Setting;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\FromCollection;

class SettingSheet implements FromCollection, WithTitle
{
    public function collection()
    {
        return Setting::all();
    }

    /**
     * @return string
     */
    public function title(): string
    {
        return 'Setting';
    }
}
