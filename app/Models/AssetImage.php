<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AssetImage extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'assets_images';

    protected $primaryKey = 'id';

    protected $fillable = ['asset_id', 'image', 'image_url'];

    protected $hidden = ['created_at', 'deleted_at', 'is_deleted'];
}
?>