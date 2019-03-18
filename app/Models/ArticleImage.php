<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ArticleImage extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'article_images';

    protected $primaryKey = 'id';

    protected $fillable = ['article_id', 'image', 'image_url'];

    protected $hidden = ['created_at', 'deleted_at', 'is_deleted'];
}
?>