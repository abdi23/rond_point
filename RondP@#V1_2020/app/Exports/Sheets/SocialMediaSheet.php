<?php

namespace App\Exports\Sheets;

use App\Models\Socialmedia;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\FromCollection;

class SocialMediaSheet implements FromCollection, WithTitle
{
    public function collection()
    {
        return Socialmedia::all();
    }

    /**
     * @return string
     */
    public function title(): string
    {
        return 'Socialmedia';
    }
}
