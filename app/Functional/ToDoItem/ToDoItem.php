<?php 

namespace App\Functional\ToDoItem;

use App\Functional\Account\Account;
use App\Functional\ToDoItem\Services\AddToDoItem;
use App\Functional\ToDoItem\Services\GetToDoItems;
use App\Models\ToDoItem as ModelsToDoItem;

class ToDoItem extends Account implements IToDoItem{
    use AddToDoItem,GetToDoItems;
    public $_toDoItem;

    public function __construct($slug)
    {   
        $this->_toDoItem = ModelsToDoItem::where('slug',$slug)->first();
    }

    public function getToDoItem(){
        
    }

    
}