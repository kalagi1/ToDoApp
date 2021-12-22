<?php 

namespace App\Functional\ToDoItem\Services;

use App\Functional\Helper\Helper;
use App\Functional\ToDoItem\ToDoItem;
use App\Models\ToDoItem as ModelsToDoItem;
use App\Models\User;
use Elasticsearch\ClientBuilder;

trait GetToDoItems{
    public static function getToDoItems(){
        $orderBy = Helper::emptyCheck(request('order_by'),'asc');
        $orderByColumn = Helper::emptyCheck(request('order_by_column'),'id');

        $todoitems = ModelsToDoItem::query();

        $todoitems = $todoitems->where('user_id',self::userDetail()->id)->orderBy($orderByColumn,$orderBy);

        if(!empty(request('search_value'))){
            $todoitems = $todoitems->where('title','like','%'.request('search_value').'%');
        }

        if(!empty(request('item_count'))){
            $todoitems = $todoitems->skip(request('start'))->take(request('item_count'));
        }

        if(!empty(request('end_date'))){
            $todoitems = $todoitems->where('end_date',Helper::endDateFilterTypeCreator(request('end_date_filter_type')),request('end_date'));
        }

        $todoitems = $todoitems->get();

        return response()->success("",$todoitems,200);

    }
}