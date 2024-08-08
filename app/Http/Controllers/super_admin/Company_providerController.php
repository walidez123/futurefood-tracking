<?php

namespace App\Http\Controllers\super_admin;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Http\Request;
use App\Models\Company_provider;


class Company_providerController extends Controller
{
    public function __construct()
    {
        // $this->middleware('permission:show_contactUs', ['only' => 'index', 'show']);
        // $this->middleware('permission:delete_contactUs', ['only' => 'destroy']);
    }

    public function index(request $request)
    {
        $Company_providers = Company_provider::where('user_id',$request->id)->orderBy('id', 'desc')->get();
        $user_id=$request->id;

     
        return view('super_admin.companies.company_intgration.index', compact('Company_providers','user_id'));
    }

    public function create(request $request)
    {
        $user_id=$request->id;

     
        return view('super_admin.companies.company_intgration.create', compact('user_id'));
    }

    public function edit($id)
    {
        $Company_provider = Company_provider::findOrFail($id);

     
        return view('super_admin.companies.company_intgration.edit', compact('Company_provider'));
    }

   public function store(request $request)
   {

     $Company_provider = Company_provider::where('app_id', $request->app_id)->where('provider_name', $request->provider_name)->first();
    if ($Company_provider != null) {
            return redirect()->back()->with('error', ' تم إنشاء هذا التطبيق من قبل');

    }      
      $Company_provider=new Company_provider();

      $Company_provider->create($request->all());
      $id=$request->user_id;
      return redirect()->route('company_providers.index', ['id'=>$id]);

   }

   public function update(request $request,$id)
   {
      
    $Company_provider = Company_provider::whereNot('id',$id)->where('app_id', $request->app_id)->where('provider_name', $request->provider_name)->first();
    if ($Company_provider != null) {
            return redirect()->back()->with('error', ' تم إنشاء هذا التطبيق من قبل');

    }

      $Company_provider = Company_provider::findOrFail($id);
      $Company_provider->update($request->all());
      return redirect()->route('company_providers.index', ['id'=>$Company_provider->user_id]);

   }

   public function destroy($id)
   {
       $Company_provider = Company_provider::findOrFail($id);
       if ($Company_provider) {
           $Company_provider->delete();
       }
       $notification = [
           'message' => '<h3>Delete Successfully</h3>',
           'alert-type' => 'success',
       ];

       return redirect()->route('company_providers.index', ['id'=>$Company_provider->user_id]);
    }

   
}
