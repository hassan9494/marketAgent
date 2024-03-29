<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ServiceController extends Controller
{
    public function index()
    {

        $categories = Category::with(['service' => function ($query) {
            $query->userRate()->where('service_status', 1);
        }])
            ->where('status', 1)
//            ->where('type', '<>', '5SIM')
            ->get();
        return view('user.pages.services.categories', compact('categories'));
    }

    public function service($id)
    {

        $category = Category::find($id);
//        if ($category->type == '5SIM')
//            return redirect()->route('user.service.show');
        $services = Service::where('category_id', $id)->userRate()->where('service_status', 1)->get();
        return view('user.pages.services.show-services', compact('services', 'category'));
    }


    public function search(Request $request)
    {
        $categories = Category::with('service')->where('status', 1)->get();
        $search = $request->all();
        $services = Service::where('service_status', 1)
            ->userRate()
            ->when(isset($search['service']), function ($query) use ($search) {
                return $query->where('service_title', 'LIKE', "%{$search['service']}%");
            })
            ->when(isset($search['category']), function ($query) use ($search) {
                return $query->where('category_id', $search['category']);
            })
            ->with(['category'])
            ->get()
            ->groupBy('category.category_title');
        return view('user.pages.services.search-service', compact('services', 'categories'));
    }

    public function getPlayerName($player, $category)
    {
        $player = (new \App\Services\SymService)->getPlayerName($category, $player);
        return $player;
    }
}
