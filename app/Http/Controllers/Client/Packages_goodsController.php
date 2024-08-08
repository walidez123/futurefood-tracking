<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Client_packages_good;
use App\Models\packages_goods;
use App\Models\Good;
use App\Models\Warehouse_branche;
use Illuminate\Http\Request;
use App\Models\Packages_history;

class Packages_goodsController extends Controller
{
   

    public function index(request $request)
    {
        if(Auth()->user()->work==3)
        {
        $type=1;}
        else{
            $type=2;
        }
        $client_packages_goods = Client_packages_good::where('company_id', Auth()->user()->company_id)->where('client_id', Auth()->user()->id)->orderBy('id', 'desc')->paginate(25);


        return view('client.packages_goods.index', compact('client_packages_goods','type'));
    }

    public function show($id)
    {
        $packages_good = Client_packages_good::find($id);
        $Packages_historys = Packages_history::where('Client_packages_good', $id)->paginate(25);

        return view('client.packages_goods.show', compact('packages_good', 'Packages_historys'));

    }

    public function searchProduct(request $request)
    {
       
        if(Auth()->user()->work==1)
        {
            $warehouse_branchs = Warehouse_branche::whereIn('work', [1,3])->where('company_id', Auth()->user()->company_id)->get();
            $goods = Good::where('company_id', Auth()->user()->company_id)->where('client_id',null)->get();


        }else{
            $warehouse_branchs = Warehouse_branche::whereIn('work', [2,3])->where('company_id', Auth()->user()->company_id)->get();
            $goods = Good::where('client_id', Auth()->user()->id)->get();


        }

        if ($request->exists('type')) {
            $from = $request->get('from');
            $to = $request->get('to');
            $warehouse_branch = $request->get('warhouse_id');
            $single_good = $request->get('goods');
            $packages_goods=Client_packages_good::where('client_id',Auth()->user()->id);
            if ($from != null && $to != null) {
                if ($request->type == 'ship') {

                    $packages_goods = $packages_goods->whereDate('updated_at', '>=', $from)
                        ->whereDate('updated_at', '<=', $to);

                } else {
                    $packages_goods = $packages_goods->packages_goods::whereDate('updated_at', '>=', $from)
                        ->whereDate('updated_at', '<=', $to);
                }
            }

            if ($warehouse_branch != null) {
                $packages_goods->where('warehouse_id', $warehouse_branch);
            }

            if ($single_good != null) {

                $packages_goods = $packages_goods->where('good_id',$single_good);
               
            }
            $Packages_goods = $packages_goods->get();

            $totalGoodsCount = $Packages_goods->sum('number');
            $packages_goods=$packages_goods->paginate(25);


            return view('client.packages_goods.search_product', compact('totalGoodsCount', 'goods', 'packages_goods', 'warehouse_branchs', 'from', 'to', 'single_good', 'warehouse_branch'));

        } else {

            return view('client.packages_goods.search_product', compact('goods', 'warehouse_branchs'));
        }
    }

    public function clientSearch(request $request)
    {
       


        if ($request->exists('type')) {
            $from = $request->get('from');
            $to = $request->get('to');
            $singelClient = $request->get('client_id');
            $warehouse_branch = $request->get('warhouse_id');
            $packages_goods = Client_packages_good::where('client_id', Auth()->user()->id);
            if ($from != null && $to != null) {
                if ($request->type == 'ship') {

                    $packages_goods = $packages_goods->whereDate('updated_at', '>=', $from)
                        ->whereDate('updated_at', '<=', $to);

                } else {
                    $packages_goods = $packages_goods->whereDate('updated_at', '>=', $from)
                        ->whereDate('updated_at', '<=', $to);
                }
            }
            if ($singelClient != null) {
                $packages_goods->where('client_id', $singelClient);
            }
            $packagesGoods=$packages_goods->get();

           

            $totalGoodsCount = $packagesGoods->sum(function ($package) {
                return $package->number;
            });
            $packages_goods = $packages_goods->paginate(25);

            return view('client.packages_goods.search', compact('packages_goods', 'totalGoodsCount', 'from', 'to', 'singelClient'));

        } else {

            return view('client.packages_goods.search');
        }

    }
}
