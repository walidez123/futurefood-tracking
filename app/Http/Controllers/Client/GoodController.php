<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Good;
use Illuminate\Http\Request;
use App\Jobs\ImportGoodsFromExcelAdmin;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

class GoodController extends Controller
{
    public function __construct()
    {

    }

    public function index()
    {
        $goods = Good::where('company_id', Auth()->user()->company_id)->where('client_id', Auth()->user()->id)->paginate(25);

        return view('client.goods.index', compact('goods'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $Categories = Category::where('company_id', Auth()->user()->company_id)->get();

        if($Categories->count() == 0){
            $Categories = Category::where('company_id', 0)->get();

        }
        return view('client.goods.add', compact('Categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'title_en' => 'required',
            'title_ar' => 'required',
            'SKUS' => 'required|unique:goods,SKUS',
            'length' => 'nullable|numeric|min:0',
            'width' => 'nullable|numeric|min:0',
            'height' => 'nullable|numeric|min:0',
            'has_expire_date' => 'nullable|min:0',

        ]);
        $GoodData = $request->all();

        if ($request->hasFile('image')) {
            $avatar = 'avatar/'.$request->file('image')->hashName();
            $uploaded = $request->file('image')->storeAs('public', $avatar);
            if ($uploaded) {
                $GoodData['image'] = $avatar;
            }

        }

        Good::create($GoodData);

        $notification = [
            'message' => '<h3>Saved Successfully</h3>',
            'alert-type' => 'success',
        ];

        return redirect()->route('client-goods.index')->with($notification);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        $Good=Good::findOrFail($id);
        return view('client.goods.show', compact('Good'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $Good = Good::find($id);

        $Categories = Category::where('company_id', Auth()->user()->company_id)->get();

        if($Categories->count() == 0){
            $Categories = Category::where('company_id', 0)->get();

        }
        return view('client.goods.edit', compact('Good', 'Categories'));
    }

    public function Qrcode($id, request $request)
    {
        $type = 'Qrcode';
        $Good = Good::find($id);

        return view('client.goods.Qrcode', compact('Good', 'type'));

    }

    public function Barcode($id, request $request)
    {
        $type = 'Barcode';
        $Good = Good::find($id);

        return view('client.goods.Qrcode', compact('Good', 'type'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $request->validate([
            'title_en' => 'required',
            'title_ar' => 'required',
            'SKUS' => 'required|unique:goods,SKUS,'.$id,

            'length' => 'nullable|numeric|min:0',
            'width' => 'nullable|numeric|min:0',
            'height' => 'nullable|numeric|min:0',
        ]);
        $Good = Good::findOrFail($id);
        $GoodData = $request->all();
        if ($request->hasFile('image')) {
            $avatar = 'avatar/'.$request->file('image')->hashName();
            $uploaded = $request->file('image')->storeAs('public', $avatar);
            if ($uploaded) {
                $GoodData['image'] = $avatar;
            }

        }
        if($request->has_expire_date ==null)
        {
            $GoodData['has_expire_date'] = 0;

        }else{
            $GoodData['has_expire_date'] = 1;

        }

        $Good->update($GoodData);
        $notification = [
            'message' => '<h3>Saved Successfully</h3>',
            'alert-type' => 'success',
        ];

        return redirect()->route('client-goods.index')->with($notification);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        Good::findOrFail($id)->delete();
        $notification = [
            'message' => '<h3>Delete Successfully</h3>',
            'alert-type' => 'success',
        ];

        return back()->with($notification);
    }
        // import from excel 
        public function import_execl(request $request){
            try {
                $user=Auth()->user();
                $file = 'excel/admin/'.$request->file('import_file')->hashName();
                $filePath = $request->file('import_file')->storeAs('public', $file);
                dispatch(new ImportGoodsFromExcelAdmin($filePath, $user));
    
                return redirect()->back()->with('success', 'Data imported successfully');
            } catch (\Exception $e) {
                return redirect()->back()->with('error', 'Error during import');
            }
        }
       //end
       public function download_execl(){
        $file= public_path(). "/goods_excel_dont_delete_it/goods.xlsx";
        $headers = array(
            'Content-Type: application/pdf',
          );

         return response()->download($file, 'goods.xlsx', $headers);

    }
    public function details($id){
        $Good=Good::findOrFail($id);
        return view('client.goods.print', compact('Good'));

    }
}
