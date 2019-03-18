<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ScriptInclude extends Model
{
    protected $table = 'scripts_include';
    protected $fillable = [];

    public static function getAllScripts() {
        $query = self::where('is_active', 1);
        $query->orderBy('position', 'asc');
        $tmp = $query->get()->toArray();

        $objects = [];
        foreach ($tmp as $item) {
            $objects[$item['key']] = $item;
        }

        return $objects;
    }
}
