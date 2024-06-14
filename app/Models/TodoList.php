<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use \App\StatusEnum;
use Illuminate\Database\Eloquent\Relations\HasMany;
class TodoList extends Model
{
    use HasFactory;


    protected $fillable = [
        'user_id',
        'title',
        'description',
        'status',
        'parent_id',
        'priority',
        'completedAt',
    ];
    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i',
        'status' => StatusEnum::class,
    ];

    


	public function user()
	{
		return $this->belongsTo(User::class,'user_id','id');
	}
    public function parent()
    {
        return $this->hasMany(TodoList::class,'parent_id');
    }
    public function childrenTodoList()
    {
        return $this->hasMany(TodoList::class,'parent_id')->with('parent');
    }
}
