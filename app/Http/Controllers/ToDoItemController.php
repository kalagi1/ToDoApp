<?php

namespace App\Http\Controllers;

use App\Functional\Account\Account;
use App\Functional\ToDoItem\ToDoItem;
use Illuminate\Http\Request;

class ToDoItemController extends Controller
{
    

    public function index(){
        return ToDoItem::getToDoItems();
    }

    public function store(){
        return ToDoItem::addToDoItem();
    }

    public function show($id){
        $toDoItem = new ToDoItem($id);
        return $toDoItem->getToDoItem();
    }

    public function update($id){
        $toDoItem = new ToDoItem($id);
        return $toDoItem->updateToDoItem();
    }

    public function destroy($id){
        $toDoItem = new ToDoItem($id);
        return $toDoItem->deleteItem();
    }
    
}
