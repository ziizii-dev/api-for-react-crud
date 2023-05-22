<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserList extends Model
{
    use HasFactory;
    protected $fillable = [ 'name','email','phone','address','status'];
    public function todos(){
        return $this->hasMany (Todo::class)->where('status',1);
    }
}
