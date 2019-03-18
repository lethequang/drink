<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Roles extends Model
{
    protected $table = 'roles';
    protected $primaryKey = 'id';
    protected $guarded = ['id'];
    protected $fillable = ['name', 'created_at', 'updated_at', 'is_deleted'];

    public static function getAllData(){
        $query = self::select('*')->where('is_deleted',0);
        return $query->get()->toArray();
    }
}
