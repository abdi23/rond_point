<?php

namespace App\Exports\Sheets;

use App\Models\TermTaxonomy;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\FromCollection;

class TermTaxonomySheet implements FromCollection, WithTitle
{
    public function collection()
    {
        return TermTaxonomy::all();
    }

    /**
     * @return string
     */
    public function title(): string
    {
        return 'Term Taxonomy';
    }
}
