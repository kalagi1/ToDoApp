<?php

namespace App\Jobs;

use App\Models\ToDoItem;
use GuzzleHttp\Client;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class Reminder implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $_todoItem;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($todoItem)
    {
        $this->_todoItem = ToDoItem::where('id',$todoItem)->first();
    }


    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $client = New Client();
        $client->request('GET', $this->_todoItem->reminder_url , ['to_do_item' => $this->_todoItem]);
    }

    public function failed(\Exception $e = null)
    {
        echo $e->getMessage();
    }
}
