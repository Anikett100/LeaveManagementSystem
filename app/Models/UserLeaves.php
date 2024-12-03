<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserLeaves extends Model
{
    use HasFactory;
    protected $table='userleaves';
    protected $fillable = [
        'leavecategory', 'leavetype', 'cc', 'fromdate','todate', 'noofdays', 'reason', 'user_id','issandwich','status','created_at','updated_at'
    ];
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class,'user_id');
    }
}
