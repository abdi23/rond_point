<?php

namespace App\Imports\Sheets;

use App\Models\Post;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\RegistersEventListeners;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\BeforeSheet;

class PostSheetImport implements ToModel, WithEvents
{
    use Importable, RegistersEventListeners;

    public static function beforeSheet(BeforeSheet $event)
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Post::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }

    /**
     * @param array $row
     *
     * @return Model|null
     */
    public function model(array $row)
    {
        return new Post([
            'id'               => $row[0],
            'post_title'       => $row[1],
            'post_name'        => $row[2],
            'post_summary'     => $row[3],
            'post_content'     => $row[4],
            'meta_description' => $row[5],
            'meta_keyword'     => $row[6],
            'post_status'      => $row[7],
            'post_visibility'  => $row[8],
            'post_author'      => $row[9],
            'post_type'        => $row[10],
            'post_guid'        => $row[11],
            'post_hits'        => $row[12] == null ? '0' : $row[12],
            'like'             => $row[13],
            'post_image'       => $row[14],
            'post_image_meta'  => $row[15],
            'post_mime_type'   => $row[16] == null ? '' : $row[16],
            'comment_status'   => $row[17] == null ? 'open' : $row[17],
            'comment_count'    => $row[18] == null ? '0' : $row[18],
            'created_at'       => $row[19],
            'updated_at'       => $row[20],
        ]);
    }
}
