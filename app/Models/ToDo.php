<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ToDo extends Model
{
    use HasFactory;
    protected $fillable =[
          'todo',
          'user_list_id',
          'status'
    ];
    public function userList(){
        return $this->belongsTo(UserList::class)->where('status',1);
    }
}
