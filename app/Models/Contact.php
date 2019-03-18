<?php
 namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'contacts';

    protected $primaryKey = 'id';

    protected $fillable = ['name', 'email', 'content', 'reply', 'status', 'created_at', 'updated_at', 'is_deleted'];

//    protected $hidden = ['deleted_at', 'is_deleted'];

    public static function getListAll($filter)
    {
        $sql = self::select('contacts.*');
        $sql->where('contacts.is_deleted', 0);

        if (!empty($keyword = $filter['search'])) {
            $sql->where(function ($query) use ($keyword) {
                $query->where('contacts.name', 'LIKE', '%' . $keyword . '%');
            });
        }
        if (isset($filter['status'])) {
            $sql->where('contacts.status', $filter['status']);
        }

        $total = $sql->count();

        $data = $sql->skip($filter['offset'])
            ->take($filter['limit'])
            ->orderBy($filter['sort'], $filter['order'])
            ->get()
            ->toArray();

        return ['total' => $total, 'data' => $data];
    }

    public static function getContact()
    {
        $sql = self::select('contacts.*');
        $sql->where('contacts.is_deleted', 0);
        $data = $sql->orderBy('updated_at', 'DESC')
            ->first()
            ->toArray();
        return  $data;
    }

    public static function getStatusFilter()
    {
        return array(
            '1' => 'Đã phản hồi',
            '0' => 'Chưa phản hồi',
        );
    }
}
