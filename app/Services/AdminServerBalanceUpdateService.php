<?php


namespace App\Services;


use Illuminate\Support\Facades\Auth;

class AdminServerBalanceUpdateService
{
    public function updateBalance($admin){
        $server_connection = new SymService();
        $order_param = array();
        $order_param['action'] = 'balance';
        $server_services = $server_connection->serverRequest($order_param);
        if (!isset($server_services['errors'])){
            if (isset($server_services['balance'])){
                $admin->server_balance = $server_services['balance'];
                $admin->save();
            }
        }
    }

}
