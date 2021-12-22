<?php 

namespace App\Functional\ToDoItem\Services;

use App\Models\ToDoItem;
use Carbon\Carbon;
use Illuminate\Contracts\Bus\Dispatcher;
use Illuminate\Support\Facades\Validator;

trait AddToDoItem{
    public static function addToDoItem(){
        $validator = Validator::make(request()->all(), [
            'title' => 'required',
            'description' => 'required',
            'end_date' => 'required',
            'priority' => 'required',
        ]);

        if(!empty(request('reminder'))){
            $validator = Validator::make(request()->all(), [
                'reminder_url' => 'required',
            ]);
        }

        if ($validator->fails()) {
            return response()->error('Invalid paramaters',$validator->errors(), 400);
        }

        $ToDoItem = ToDoItem::create([
            "user_id" => self::userDetail()->id,
            "title" => request('title'),
            "description" => request('description'),
            "end_date" => request('end_date'),
            "end_time" => request('end_time'),
            "priority_id" => request('priority'),
            "reminder" => request('reminder'),
            'reminder_url' => request('reminder_url')
        ]);
        if(!empty(request('reminder'))){
            if(!empty(request('end_time'))){
                $datetime = new Carbon(request('end_date').request('end_time'));
            }else{
                $datetime = new Carbon(request('end_date').'23:59:59');
            }
            $datetime = strtotime($datetime) - time() - 1800;
            $job = ( new \App\Jobs\Reminder($ToDoItem->id) )->onQueue('reminder_'.$ToDoItem->id)->delay($datetime);
            dispatch($job);
        }
        
        

        if($ToDoItem->save()){
            return response()->success("You have successfully added element",[$ToDoItem], 201 );
        }

    }   
}