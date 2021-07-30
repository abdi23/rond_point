<?php

namespace App\Exports\Sheets;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\FromCollection;

class TermRelationshipSheet implements FromCollection, WithTitle
{
    public function collection()
    {
        return DB::table('term_relationships')->get();
    }

    /**
     * @return string
     */
    public function title(): string
    {
        return 'Term Relationship';
    }
}
