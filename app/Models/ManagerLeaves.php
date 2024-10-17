<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ManagerLeaves extends Model
{
    use HasFactory;
    protected $table="managerleaves";

    public function user()
{
    return $this->belongsTo(User::class);
}

protected $fillable = [
    'leavecategory', 'leavetype', 'issandwich', 'fromdate', 'todate', 'noofdays', 'reason', 'status', 'actionreason',
];

}

