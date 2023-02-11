<?php

namespace App\Console\Commands;

use App\Http\Traits\Notify;
use App\Models\Order;
use App\Models\Transaction;
use App\Services\SymService;
use App\Services\TransactionService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UpdateOrdersStatus extends Command
{
    use Notify;

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
        foreach ($server_orders as $server_order) {
            $order = Order::where('api_order_id', $server_order['id'])->first();
            if (isset($order))
                if ($order->status != $server_order['status']) {
                    $order->status = $server_order['status'];
                    DB::beginTransaction();
                    $order->save();
                    if ($server_order['status'] == 'refunded') {
                        $user = $order->users;
                        $user->balance += $order->price;

                        $transaction = new TransactionService();
                        $trx_id = $transaction->transaction($user->id, '+', $order->price, 'Retrieving the balance after change the order status to a refund');
//                        $transaction = new Transaction();
//                        $transaction->user_id = $user->id;
//                        $transaction->trx_type = '+';
//                        $transaction->amount = $order->price;
//                        $transaction->remarks = 'Retrieving the balance after change the order status to a refund';
//                        $transaction->trx_id = strRandom();
//                        $transaction->charge = 0;

                        $user->save();

                        $msg = [
                            'order_id' => $order->id,
                            'status' => $order->status
                        ];
                        $action = [
                            "link" => '#',
                            "icon" => "fas fa-cart-plus text-white"
                        ];
                        @$this->userPushNotification($order->users, 'ORDER_STATUS_CHANGED', $msg, $action);
                    }
                    DB::commit();
                }
        }

    }
}
