<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductImage extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'product_images';

    protected $primaryKey = 'id';

    protected $fillable = ['product_id', 'image', 'image_url'];

    protected $hidden = ['created_at', 'deleted_at', 'is_deleted'];
}
?>