<?php

namespace App\Console\Commands;

use App\Models\Order;
use App\Services\SymService;
use Illuminate\Console\Command;

class UpdateOrdersStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'updateOrders:status';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'update orders status dinamicaly';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $server_connection = new SymService();
        $order_param = array();
        $order_param['action'] = 'sync_orders';
        $server_orders = $server_connection->serverRequest($order_param);
        foreach ($server_orders as $server_order){
            $order = Order::where('api_order_id',$server_order['id'])->first();
            if (isset($order))
                if ($order->status != $server_order['status']){
                    $order->status = $server_order['status'];
                    $order->save();
                }
        }

    }
}
