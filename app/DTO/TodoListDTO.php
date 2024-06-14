<?php

namespace App\DTO;

class TodoListDTO
{
    public  $user_id;
    public  $title;
    public  $description;
    public  $priority;
    public  $parent_id;
    public  $completedAt;
    public function __construct(
        $user_id, 
        $title, 
        $description,
        $priority,
        $parent_id,
        $completedAt,
    ) {
        $this->user_id = $user_id;
        $this->title = $title;
        $this->description = $description;
        $this->priority = $priority;
        $this->parent_id = $parent_id;
        $this->completedAt = $completedAt;

    }
        
    
}
?>