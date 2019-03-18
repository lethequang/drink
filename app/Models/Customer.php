<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'customers';

    protected $primaryKey = 'id';

    protected $fillable = [
        'fullname', 'name', 'email', 'password', 'phone', 'avatar', 'birthdate',
        'status', 'is_deleted', 'gender', 'created_at', 'updated_at', 'address'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public static function getStatusFilter()
    {
        return array(
            '1' => 'Đang hoạt động',
            '0' => 'Không hoạt động',
        );
    }
    public static function getAll()
    {
        $data = Customer:: where('is_deleted', 0)->pluck('fullname', 'id');//->pluck('name','district_id');

        if (!empty($data)) {
            return $data->toArray();
        }

        return  array();
    }
    public static function getInfoCustomer()
    {
        $data = Customer:: where('is_deleted', 0)->pluck('fullname', 'id');//->pluck('name','district_id');

        if (!empty($data)) {
            return $data->toArray();
        }

        return  array();
    }
}
