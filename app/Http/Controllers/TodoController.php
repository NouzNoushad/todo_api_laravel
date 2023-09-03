<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class TodoController extends Controller
{
    public function getTodoList($id=null){
        $todoList = DB::table('todos');
        $todo = $id ? $todoList->find($id) : $todoList->get();
        if($todo){
            return response()->json(['result' => $todo], 200);
        }
        else{
            return response()->json(['result' => 'Todo not found'], 404);
        }
    }

    public function addOrUpdateTodo(Request $request){
        $todoList = DB::table('todos');
        $rules = array(
            'title' => 'required | max:50',
            'content' => 'required'
        );

        $validator = Validator::make($request->all(), $rules);
        if($validator->fails()){
            return response()->json($validator->errors(), 402);
        }else{
            $todoList->updateOrInsert([
                'id' => $request->id
            ], [
                'title' => $request->title,
                'content' => $request->content,
                'created_at' => now(),
                'updated_at' => now()
            ]);

            if($todoList){
                return response()->json(['result' => 'Success'], 200);
            }
            else{
                return response()->json(['result' => 'Todo not found'], 404);
            }
        }
    }

    public function deleteTodo(Request $request){
        $todoList = DB::table('todos');
        $rules = array(
            "id" => 'required',
        );
        $validator = Validator::make($request->all(), $rules);

        if($validator->fails()){
            return response()->json($validator->errors(), 402);
        }
        else{
            $todo = $todoList->where('id', $request->id)->delete();
            if($todo){
                    return response()->json(['result' => 'Todo deleted'], 200);
                }
                else{
                    return response()->json(['result' => 'Todo not found'], 404);
                }
        }
    }
}
