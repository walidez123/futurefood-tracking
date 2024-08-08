<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\DamagedGoods;
use App\Models\User;
use App\Models\Warehouse_branche;
use App\Models\Good;
use App\Models\Warehouse_content;
use App\Models\GoodsStatus;
use Illuminate\Http\Request;
use App\Models\Client_packages_good;
use App\Models\Packages_history;

class DamagedGoodsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $damagedGoods = DamagedGoods::with(['client', 'warehouseBranch', 'goods', 'warehouseContent', 'goodsStatus'])->where('client_id',Auth()->user()->id)->orderBy('id','DESC')->paginate(20);
        return view('Client.damaged_goods.index', compact('damagedGoods'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $clients = User::where('company_id', Auth()->user()->company_id)->where('work', 4)->get();
        $warehouseBranches = Warehouse_branche::where('company_id', Auth()->user()->company_id)->where('work',2)->get();
        $goodsStatuses = GoodsStatus::get();

        return view('admin.damaged_goods.create', compact('clients', 'warehouseBranches', 'goodsStatuses'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
   
    public function store(Request $request)
    {
        // Validate the incoming request data for each array field
        $request->validate([
            'client_id' => 'required|exists:users,id',
            'warehouse_branche_id' => 'required|exists:warehouse_branches,id',
            'good_id.*' => 'required|exists:goods,id',
            'warehouse_content_id.*' => 'required|exists:warehouse_contents,id',
            'goods_status_id.*' => 'required|exists:goods_statuses,id',
            'number.*' => 'required|integer|min:1',
        ]);

        // Get the array of inputs for each field
        $clientId = $request->input('client_id');
        $warehouseBranchId = $request->input('warehouse_branche_id');
        $goodIds = $request->input('good_id');
        $warehouseContentIds = $request->input('warehouse_content_id');
        $goodsStatusIds = $request->input('goods_status_id');
        $numbers = $request->input('number');

        // Loop through each set of input values and create a new DamagedGood record
        foreach ($goodIds as $key => $goodId) {
           $damage= DamagedGoods::create([
                'client_id' => $clientId,
                'warehouse_branche_id' => $warehouseBranchId,
                'good_id' => $goodIds[$key],
                'warehouse_content_id' => $warehouseContentIds[$key],
                'goods_status_id' => $goodsStatusIds[$key],
                'number' => $numbers[$key],
            ]);
            if($damage){
                $package = Client_packages_good::where('good_id', $damage->good_id)
                ->where('client_id', $damage->client_id)
                ->where('packages_id',$damage->warehouse_content_id)
                ->first();
                if($package){
                $package->number=$package->number-$damage->number;
                $package->save();
                $Packages_historiy=new Packages_history();
                $Packages_historiy->Client_packages_good=$package->id;
                $Packages_historiy->number=$damage->number;
                $Packages_historiy->type=4;
                $Packages_historiy->user_id=Auth()->user()->id;
                $Packages_historiy->save();

                }

                
            }
          
        }

        // Redirect the user to the index page with a success message
        return redirect()->route('damaged-goods.index')->with('success', 'Damaged goods recorded successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\DamagedGoods  $damagedGood
     * @return \Illuminate\Http\Response
     */
    public function show(DamagedGoods $damagedGood)
    {
        return view('admin.damaged_goods.show', compact('damagedGood'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\DamagedGoods  $damagedGood
     * @return \Illuminate\Http\Response
     */
   
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\DamagedGoods  $damagedGood
     * @return \Illuminate\Http\Response
     */
   

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\DamagedGoods  $damagedGood
     * @return \Illuminate\Http\Response
     */
    public function destroy(DamagedGoods $damagedGood)
    {
        $damagedGood->delete();

        return redirect()->route('damaged-goods.index')->with('success', 'Damaged goods deleted successfully.');
    }
}
