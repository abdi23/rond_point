<?php

namespace App\Models;

use App\Helpers\Settings;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Spatie\Feed\Feedable;
use Spatie\Feed\FeedItem;

class Post extends Model implements Feedable
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'post_title',
        'post_summary',
        'post_name',
        'post_content',
        'post_image',
        'post_image_alt',
        'post_hits',
        'post_author',
        'post_type',
        'post_status',
        'post_visibility',
        'post_mime_type',
        'post_guid',
        'post_image_meta',
        'meta_description',
        'meta_keyword'
    ];

    /**
     * @return BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User', 'post_author');
    }

    /**
     * @return BelongsToMany
     */
    public function termtaxonomy()
    {
        return $this->belongsToMany('App\Models\TermTaxonomy','term_relationships','post_id','term_taxonomy_id')->withTimestamps();
    }

    /**
     * @return HasManyThrough
     */
    public function term()
    {
        return $this->hasManyThrough(
            'App\Models\Term',
            'App\Models\TermTaxonomy',
            'term_id',
            'id',
            'id',
            'id'
        );
    }

    /**
     * @param $query
     * @return mixed
     */
    public function scopePostType($query)
    {
        return $query->wherePostType('post');
    }

    /**
     * @param $query
     * @param $type
     * @return mixed
     */
    public function scopeOfType($query, $type)
    {
        return $query->wherePostType($type);
    }

    /**
     * @return FeedItem
     */
    public function toFeedItem(): FeedItem
    {
        return FeedItem::create([
            'id'      => $this->id,
            'title'   => $this->post_title,
            'summary' => $this->post_summary == null ? "" : $this->post_summary,
            'updated' => $this->updated_at,
            'link'    => Settings::getRoutePost($this),
            'author'  => $this->user()->first()->name,
        ]);
    }

    /**
     * @return mixed
     */
    public static function getFeedItems()
    {
        return Post::where('post_type', 'post')->with('user')->get();
    }
}
