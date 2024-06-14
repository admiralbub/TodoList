<?php

declare(strict_types=1);

namespace App\Services\TodoListService;

use App\Contracts\Services\TodoListService\TodoListServiceInterface;
use App\Models\TodoList;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use LogicException;
use App\DTO\TodoListDTO;
class TodoListService implements TodoListServiceInterface
{
    public function filter_status(TodoList $todolist, string $status) {
        return $todolist->with('childrenTodoList')->where('status',$status)->get();
       
    }
    public function filter_priority(TodoList $todolist,$priority) {
        return $todolist->with('childrenTodoList')->where('priority',$priority)->get();
       
    }
    public function filter_title(TodoList $todolist,string $title) {
        return $todolist->with('childrenTodoList')->where('title', 'like', '%' . $title . '%')->get();
    }
    public function filter_description(TodoList $todolist,string $description) {
        return $todolist->with('childrenTodoList')->where('description', 'like', '%' . $description . '%')->get();
    }
    public function sort_todo(TodoList $todolist,$priority_sort, $created_at_sort, $completed_at_sort) {
        return $todolist->with('childrenTodoList')->orderBy('priority', $priority_sort ?? 'asc')
            ->orderBy('created_at', $created_at_sort ?? 'asc')
            ->orderBy('completedAt', $completed_at_sort ?? 'asc')
            ->get();
    }
    public function show(TodoList $todolist) {
        return $todolist->with('childrenTodoList')->get();
    }
    public function create(TodoListDTO $todolistdto): TodoList {
        $todolist = new TodoList();
        $todolist->user_id = $todolistdto->user_id;
        $todolist->title = $todolistdto->title;
        $todolist->description =  $todolistdto->description;
        $todolist->priority = $todolistdto->priority;
        $todolist->parent_id = $todolistdto->parent_id;
        $todolist->completedAt = $todolistdto->completedAt;
        $todolist->save();
        return $todolist;
    }
    public function update(TodoListDTO $todolistdto,$id): void {
        $todolist = TodoList::where('id',$id)->update([
            'user_id' =>  $todolistdto->user_id,
            'title' => $todolistdto->title,
            'description' => $todolistdto->description,
            'priority' => $todolistdto->priority,
            'parent_id' => $todolistdto->parent_id,
            'completedAt' =>  $todolistdto->completedAt,
        ]);
   
    }
    public function delete($id): void {
        $todolist = TodoList::findOrFail($id);
        
        $todolist->delete();
    }
    public function update_status(TodoList $todolist,$status,$id): void {
        $todolist->update([
            'status' =>  $status,
        ]);
   
    }
}