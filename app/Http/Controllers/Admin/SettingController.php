<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Company_setting;
use App\Models\Company_work;
use App\Models\Status;
use App\Models\User;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:edit_adminSetting', ['only' => 'setting', 'update']);

    }

    public function setting()
    {
        $user = Company_setting::where('company_id', Auth()->user()->company_id)->first();
        $Status = Status::where('company_id', Auth()->user()->company_id)->orderBy('sort', 'ASC')->get();
        $works = Company_work::where('company_id', $user->id)->pluck('work')->toArray();

        return view('admin.settings.edit', compact('user', 'Status', 'works'));
    }

    public function status()
    {
        $user = Company_setting::where('company_id', Auth()->user()->company_id)->first();
        $Status = Status::where('company_id', Auth()->user()->company_id)->orderBy('sort', 'ASC')->get();
        $works = Company_work::where('company_id', $user->id)->pluck('work')->toArray();

        return view('admin.settings.status', compact('user', 'Status', 'works'));
    }

    public function terms()
    {
        $user = Company_setting::where('company_id', Auth()->user()->company_id)->first();
        $Status = Status::where('company_id', Auth()->user()->company_id)->orderBy('sort', 'ASC')->get();
        $works = Company_work::where('company_id', $user->id)->pluck('work')->toArray();

        return view('admin.settings.terms', compact('user', 'Status', 'works'));
    }

    public function warehouse()
    {
        $user = Company_setting::where('company_id', Auth()->user()->company_id)->first();
        $works = Company_work::where('company_id', $user->id)->pluck('work')->toArray();

        return view('admin.settings.warehouse', compact('user', 'works'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $SettingData = $request->all();
        if ($request->hasFile('logo')) {
            $avatar = 'logo'.'/'.$request->file('logo')->hashName();
            $uploaded = $request->file('logo')->storeAs('public', $avatar);
            if ($uploaded) {
                $SettingData['logo'] = $avatar;
            }

        }
        $user = Auth()->user();
        $comapny = Company_setting::where('company_id', $user->company_id)->first();
        $comapny->update($SettingData);
        $user = User::where('id', $user->company_id)->first();
        $user->read_terms = 1;
        $user->save();

        $notification = [
            'message' => '<h3>تم تعديل بنجاح</h3>',
            'alert-type' => 'success',
        ];

        return redirect()->back()->with($notification);

    }
}
