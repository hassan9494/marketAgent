<?php

namespace App\Console\Commands;

use App\Http\Traits\Notify;
use App\Models\Category;
use App\Models\Service;
use App\Services\SymService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
class ServicesSync extends Command
{
    use Notify;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'services:sync';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync Services from server';

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
        $activeServerServiceIds = array();
        $order_param['action'] = 'services';
        $server_services = $server_connection->serverRequest($order_param);
        if (!isset($server_services['errors']) && $server_services){
            $services = Service::orderBy('category_id', 'asc')->get();
            foreach ($server_services as $server_service) {
                array_push($activeServerServiceIds,$server_service['service']);
                $service = $services->find($server_service['service']);
                if ($service) {
                    if ($service->is_available != $server_service['is_available'] || $service->min_amount != $server_service['min'] || $service->max_amount != $server_service['max']) {
                        $service->is_available = $server_service['is_available'];
                        $service->min_amount = $server_service['min'];
                        $service->max_amount = $server_service['max'];
                        $service->save();
                    }
                    if ($service->server_price != $server_service['rate']) {
                        $service->server_price = $server_service['rate'];
                        if (config('basic.automatic_price_refresh') == 1) {
                            $service->price = $server_service['rate'] + $server_service['rate'] * (config('basic.percentage_profit') / 100);
                            $msg = [
                                'service_id' => $service->id,
                            ];
                            $action = [
                                "link" => route('admin.service.edit', ['id' => $service->id]),
                                "icon" => "fas fa-cart-plus text-white"
                            ];
                            $this->adminPushNotification('UPDATE_SERVICE_PRICE_AUTO', $msg, $action);
                            $service->save();
                        }else{
                            $service->service_status = 0;
                            $msg = [
                                'service_id' => $service->id,
                            ];
                            $action = [
                                "link" => route('admin.service.edit', ['id' => $service->id]),
                                "icon" => "fas fa-cart-plus text-white"
                            ];
                            $this->adminPushNotification('UPDATE_SERVICE_PRICE', $msg, $action);
                            $service->save();
                        }

                    }
                }
                else{
                    $newService = new Service();
                    $newService->id = $server_service['service'];
                    $newService->service_title = $server_service['name'];
                    $category = Category::find($server_service['category_id']['id']);
                    if ($category){
                        $newService->category_id = $server_service['category_id']['id'];

                    }else{
                        $newCategory = new Category();
                        $newCategory->id = $server_service['category_id']['id'];
                        $newCategory->category_title = $server_service['category_id']['category_title'];
                        $newCategory->category_description = $server_service['category_id']['category_description'];
                        $newCategory->status = $server_service['category_id']['status'];
                        $newCategory->type = $server_service['category_id']['type'];
                        $newCategory->special_field = $server_service['category_id']['special_field'];
                        $newCategory->sort = $server_service['category_id']['sort'];
                        $newCategory->slug = $server_service['category_id']['slug'];
                        $newCategory->save();
                        $newService->category_id = $newCategory->id;

                    }

                    $newService->min_amount = $server_service['min'];
                    $newService->max_amount = $server_service['max'];

                     if (config('basic.automatic_price_refresh') == 1) {
                         $service->price = $server_service['rate'] + $server_service['rate'] * (config('basic.percentage_profit') / 100);
                         $newService->service_status = 1;
                     }else{
                    $newService->price = $server_service['rate'];
                    $newService->service_status = 0;
                     }


                    $newService->is_available = $server_service['is_available'];
                    $newService->server_price = $server_service['rate'];
                    $newService->save();
                    $msg = [
                        'service_id' => $newService->id,
                        'available' => $newService->is_available
                    ];
                    $action = [
                        "link" => route('admin.service.edit',['id'=>$newService->id]),
                        "icon" => "fas fa-cart-plus text-white"
                    ];
                    $this->adminPushNotification('ADD_SERVICE', $msg, $action);

                }
            }

            $servicesToInactivate = Service::whereNotIn('id',$activeServerServiceIds)->get();
            foreach ($servicesToInactivate as $serviceToInactivate){
                if ($serviceToInactivate->service_status != 0){
                    $serviceToInactivate->service_status = 0 ;
                    $serviceToInactivate->save();
                }
            }

        }
    }
}
