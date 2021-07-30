<?php

namespace App\Exports\Sheets;

use App\Models\Term;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\FromCollection;

class TermSheet implements FromCollection, WithTitle
{
    public function collection()
    {
        return Term::all();
    }

    /**
     * @return string
     */
    public function title(): string
    {
        return 'Term';
    }
}
