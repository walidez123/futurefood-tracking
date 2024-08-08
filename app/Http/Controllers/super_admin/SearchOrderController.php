<?php

namespace App\Http\Controllers\super_admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Order;
use App\Models\Otp_code;




use Illuminate\Http\Request;

class SearchOrderController extends Controller
{
    public function __construct()
    {
        // $this->middleware('permission:show_city', ['only' => 'index', 'show']);
        // $this->middleware('permission:add_city', ['only' => 'create', 'store']);
        // $this->middleware('permission:edit_city', ['only' => 'edit', 'update']);
        // $this->middleware('permission:delete_city', ['only' => 'destroy']);
    }

    public function index(request $request)
    {
        if($request->action=="filter")
        {
            if($request->order_id!=null)
            {

                $order = Order::withTrashed()->where('order_id', $request->order_id)->first();
                $order_id=$request->order_id;
            }
            return view('super_admin.search_order.index', compact('order','order_id'));
        }
       


        return view('super_admin.search_order.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
 

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
   

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $order = Order::findOrFail($id);
        $otps = Otp_code::where('order_id', $order->order_id)->orderBy('id', 'desc')->get();
        if ($order) {

       

            if($order->is_returned==1)
            {
                return view('super_admin.search_order.show_return', compact('order', 'otps'));


            }else{
                return view('super_admin.search_order.show', compact('order', 'otps'));

            }
           

        } else {
            abort(404);
        }


    }

    /**
     * Show the form for editing the specified resource.
     *
 
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
   

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
   

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
   
}
