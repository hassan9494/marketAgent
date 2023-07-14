<?php

namespace App\Console\Commands;

use App\Http\Controllers\OrderController;
use App\Http\Traits\Notify;
use App\Models\ApiProvider;
use App\Models\Order;
use App\Models\Transaction;
use App\Services\SymService;
use App\Services\TransactionService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Ixudra\Curl\Facades\Curl;

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
        $msaderOrders = Order::whereNotNull('api_order_id')
            ->where('created_at', '>', now()->subMinutes(10))->get();
        $msaderOrders = $msaderOrders->pluck('api_order_id');
        if (isset($msaderOrders))
            $this->updateMsaderOrders($msaderOrders);
    }

    public function updateMsaderOrders($msaderOrdersIDs)
    {
        $msaderProvider = ApiProvider::where('description', 'LIKE', 'msader');
        $this->base_url = $msaderProvider->url;
        $params = [
            'key' => $msaderProvider->api_key,
            'action' => 'orders',
            'orders' => implode(",", $msaderOrdersIDs)
        ];
        $response = Curl::to($this->base_url)->withData($params)->post();
        $orderStatus = json_decode($response, true);
        if (isset($orderStatus[0]['order'])) {
            foreach ($orderStatus as $remoteOrder) {
                $order = Order::where('api_order_id', '=', $remoteOrder['order'])->first();
                if ($order && $remoteOrder['status'] != $order->status) {
                    if ($order->category->type != "NUMBER")
                        $this->statusChange($order, $remoteOrder['status']);
                    else {
                        if ($remoteOrder['status'] == 'completed') {
                            if ($remoteOrder['code'])
                                $res = (new OrderController())->finish5SImOrder($order, ['smsCode' => $remoteOrder['code']]);
                        } else
                            $this->statusChange($order, $remoteOrder['status']);
                    }

                }
            }
        }
    }

    public function statusChange(Order $order, $status)
    {
        $user = $order->users;
        if ($status == 'refunded') {
            if ($order->status != 'refunded') {
                $user->balance += $order->price;
                $transaction1 = new Transaction();
                $transaction1->user_id = $user->id;
                $transaction1->trx_type = '+';
                $transaction1->amount = $order->price;
                $transaction1->remarks = 'استرجاع الرصيد بعد تحويل حالة الطلب الى مسترجع';
                $transaction1->trx_id = strRandom();
                $transaction1->charge = 0;
                if ($user->save()) {
                    $transaction1->save();
                }
            }
        }
        $order->status = $status;
        $order->save();
    }
}
