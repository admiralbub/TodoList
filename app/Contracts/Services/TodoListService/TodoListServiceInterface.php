<?php

declare(strict_types=1);

namespace App\Contracts\Services\TodoListService;
use App\Models\Todolist;
use App\Models\User;
use App\DTO\TodoListDTO;
interface TodoListServiceInterface
{
    public function filter_status(TodoList $todolist,string $status);
    public function filter_priority(TodoList $todolist,$priority);
    public function filter_title(TodoList $todolist,string $title);
    
    public function filter_description(TodoList $todolist,string $description);
    public function sort_todo(TodoList $todolist,$priority_sort, $created_at_sort, $completed_at_sort);
    public function show(TodoList $todolist);
    public function create(TodoListDTO $todolistdto): TodoList;
    public function update(TodoListDTO $todolistdto,$id): void;
    public function delete($id): void;
    public function update_status(TodoList $todolist,$status ,$id): void;
}

?>