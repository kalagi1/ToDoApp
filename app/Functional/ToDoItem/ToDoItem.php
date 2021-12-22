<?php 

namespace App\Functional\ToDoItem;

use App\Functional\Account\Account;
use App\Functional\ToDoItem\Services\AddToDoItem;
use App\Functional\ToDoItem\Services\GetToDoItems;
use App\Models\ToDoItem as ModelsToDoItem;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ToDoItem extends Account implements IToDoItem{
    use AddToDoItem,GetToDoItems;
    public $_toDoItem;

    public function __construct($id)
    {   
        $this->_toDoItem = ModelsToDoItem::where('id',$id)->first();
    }

    public function getToDoItem(){
        return $this->_toDoItem;
    }

    public function updateToDoItem(){
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


        $queueItem = DB::table("jobs")->where('queue','reminder_'.$this->_toDoItem->id)->first();
        $this->_toDoItem->title = request('title');
        $this->_toDoItem->description = request('description');
        $this->_toDoItem->end_date = request('end_date');
        $this->_toDoItem->priority_id = request('priority');
        if($this->_toDoItem != request('end_date')){
            $this->_toDoItem->end_date = request('end_date');
            if(!empty(request('end_time'))){
                $datetime = new Carbon(request('end_date').request('end_time'));
            }else{
                $datetime = new Carbon(request('end_date').'23:59:59');
            }
            $datetime = strtotime($datetime) - 1800;
            $this->_toDoItem->end_time = request('end_time');
            DB::table('jobs')->where('queue','reminder_'.$this->_toDoItem->id)->update(['available_at' => $datetime]);
        }
        if(!empty(request('reminder'))){
            
            if(empty($queueItem)){
                if(!empty(request('end_time'))){
                    $datetime = new Carbon(request('end_date').request('end_time'));
                }else{
                    $datetime = new Carbon(request('end_date').'23:59:59');
                }
                $datetime = strtotime($datetime) - time() - 1800;
                $job = ( new \App\Jobs\Reminder($this->_toDoItem->id) )->onQueue('reminder_'.$this->_toDoItem->id)->delay($datetime);
                dispatch($job);
            }
            
            $this->_toDoItem->reminder = 1;
            $this->_toDoItem->reminder_url = request('reminder_url');
        }else{
            $this->_toDoItem->reminder = null;
            $this->_toDoItem->reminder_url = null;
            DB::table("jobs")->where('queue','reminder_'.$this->_toDoItem->id)->delete();
        }


        if($this->_toDoItem->save()){
            return response()->success("you have successfully updated the element",$this->_toDoItem,200);
        }
    }

    public function deleteItem(){
        $queueItem = DB::table("jobs")->where('queue','reminder_'.$this->_toDoItem->id)->first();

        if(!empty($queueItem)){
            $queueItem = DB::table("jobs")->where('queue','reminder_'.$this->_toDoItem->id)->first();
        }

        if($this->_toDoItem->delete()){
            return response()->success("You have successfull deleted the element",[],200);
        }
    }

    
}