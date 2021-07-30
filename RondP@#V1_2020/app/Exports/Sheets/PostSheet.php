<?php

namespace App\Exports\Sheets;

use App\Models\Post;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\FromCollection;

class PostSheet implements FromCollection, WithTitle
{
    public function collection()
    {
        return Post::all();
    }

    /**
     * @return string
     */
    public function title(): string
    {
        return 'Post';
    }
}
