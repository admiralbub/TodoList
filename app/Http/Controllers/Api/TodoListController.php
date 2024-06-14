<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TodoList;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;
use App\Contracts\Services\TodoListService\TodoListServiceInterface;
use App\DTO\TodoListDTO;
class TodoListController extends Controller
{
    public function __construct(private readonly TodoListServiceInterface $TodoListService)
    {
    }
    public function index(TodoList $todolist, Request $request) {
        //Filter by fields
        if($request->query('status')) {
            $status = $request->query('status');
            $todolist =$this->TodoListService->filter_status($todolist,$status);
        } else if($request->query('priority')) {
            $priority = $request->query('priority');
            $todolist =$this->TodoListService->filter_priority($todolist,$priority);    
        } else if($request->query('title')) {
            $title = $request->query('title');
            $todolist =$this->TodoListService->filter_title($todolist,$title);    
        } else if($request->query('description')) {
            $description = $request->query('description');
            $todolist =$this->TodoListService->filter_description($todolist,$description);   
        } else if ($request->get('priority_sort') !="" || $request->get('created_at_sort') !="" || $request->get('completedAt') !="") {
            $priority_sort = $request->query('priority_sort');
            $created_at_sort = $request->query('created_at_sort');   
            $completed_at_sort = $request->query('completed_at_sort');      
            $todolist =  $this->TodoListService->sort_todo($todolist,$priority_sort, $created_at_sort, $completed_at_sort);   
        } else {
            $todolist = $this->TodoListService->show($todolist);   
        }


       
        return response()->json(['todolist'=>$todolist]);
    }
    public function create(Request $request) {
        
        $validator = \Validator::make(request()->all(), [
            'title' => 'required|string|max:255',
            'completedAt' => 'nullable|date',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
            ]);
        }
        $todolis_array= array(
            'user_id' => $request->user()->id,
            'title' => $request->title,
            'description' => $request->description,
            'priority' => $request->priority,
            'parent_id' => $request->parent_id,
            'completedAt' =>  $request->completedAt,
        );
        $this->TodoListService->create(new TodoListDTO(...$todolis_array));
        

        return response()->json(['message'=>'Successfully completed operation']);

    }

    public function update(Request $request,$id) {

        

        $todolist = TodoList::findorfail($id);
       
        if (! Gate::allows('update-todo', $todolist)) {
            return response()->json([
                'errors' => 'Access denied !',
            ]);
        }

        $validator = \Validator::make(request()->all(), [
            'title' => 'required|string|max:255',
            'completedAt' => 'nullable|date',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
            ]);
        }
        $todolis_array= array(
            'user_id' => $request->user()->id,
            'title' => $request->title,
            'description' => $request->description,
            'priority' => $request->priority,
            'parent_id' => $request->parent_id,
            'completedAt' =>  $request->completedAt,
        );
        $this->TodoListService->update(new TodoListDTO(...$todolis_array),$id);
        
        return response()->json(['message'=>'Successfully completed operation']);

    }

    public function delete(Request $request,$id) {

        $todolist = TodoList::where('status', 0)->findorfail($id);

        if (! Gate::allows('delete-todo', $todolist)) {
            return response()->json([
                'errors' => 'Access denied !',
            ]);
        }
        

        $this->TodoListService->delete($id);
        return response()->json(['message'=>'Successfully completed operation']);
        
        


    }

    public function update_status(Request $request,$id) {
        
        $todolist = TodoList::findorfail($id);
        if($todolist->count() == 0) {
            return response()->json([
                'errors' => "Error during operation",
            ]);
        }

        $validator = \Validator::make(request()->all(), [
            'status' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
            ]);
        }

        if (! Gate::allows('update-status', $todolist)) {
            return response()->json([
                'errors' => 'Access denied !',
            ]);
        }
        if($todolist->parent()->count() == 0) {
            $status = $request->status;
            $this->TodoListService->update_status($todolist,$status,$id);
            return response()->json(['message'=>'Successfully completed operation']);
        } else {
            return response()->json([
                'errors' => "Error during operation",
            ]);
        }
    }

}
