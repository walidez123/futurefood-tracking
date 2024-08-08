<?php

namespace App\Liberary;

use App\Models\AppSetting;
use App\Models\Company_work;
use App\Models\Notification;
use App\Models\Role;
use App\Models\Status;
use App\Models\User;
use App\Models\WebSetting;
use Illuminate\View\View;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class Settings
{
    public function compose(View $view)
    {
        $this->webSetting($view);
        $this->appSetting($view);
        $this->lang($view);
        $this->user_type($view);
        $this->status($view);

        $this->notificationsBar($view);
    }

    private function user_type(View $view)
    {
        $user_type = [];
        if (auth()->user()) {
            if (auth()->user()->user_type == 'admin' && auth()->user()->is_company == 1) {
                $id = auth()->user()->id;
                $user_type = Company_work::where('company_id', $id)->pluck('work')->toArray();
            }
            if (auth()->user()->user_type == 'admin' && auth()->user()->is_company == 0) {
                $user_type = Company_work::where('company_id', auth()->user()->company_id)->pluck('work')->toArray();
            }
            if (auth()->user()->user_type == 'service_provider' && auth()->user()->is_company == 0) {
                $user_type = Company_work::where('company_id', auth()->user()->company_id)->pluck('work')->toArray();

            }
            if (auth()->user()->user_type == 'supervisor' && auth()->user()->is_company == 0) {
                $user_type = Company_work::where('company_id', auth()->user()->company_id)->pluck('work')->toArray();

            } if (auth()->user()->user_type == 'client' && auth()->user()->is_company == 0) {
                $user_type = Company_work::where('company_id', auth()->user()->company_id)->pluck('work')->toArray();

            } if (auth()->user()->user_type == 'delegate' && auth()->user()->is_company == 0) {
                $user_type = Company_work::where('company_id', auth()->user()->company_id)->pluck('work')->toArray();

            }
            $view->with('user_type', $user_type);

        }

    }

    private function webSetting(View $view)
    {
        $id = 1;
        $webSetting = WebSetting::findOrFail($id);

        $view->with('webSetting', $webSetting);
    }

    private function status(View $view)
    {
        if (auth()->user()) {
            $statuses = Status::where('company_id', Auth()->user()->company_id)->orderBy('sort', 'ASC')->get();
        } else {
            $statuses = '';
        }

        $view->with('statuses_nav', $statuses);
    }

    private function appSetting(View $view)
    {
        $id = 1;
        $appSetting = AppSetting::findOrFail($id);

        // permissions
        if (auth()->user()) {

            if (auth()->user()->user_type == 'admin' || auth()->user()->user_type == 'super_admin') {

                if (auth()->user()->role_id == null) {

                    abort(403, 'Access Denied');
                }

                $role = Role::findOrFail(auth()->user()->role_id);

                $permissions = $role->permissions;
                $permissionsTitle = [];
                foreach ($permissions as $permission) {
                    $permissionsTitle[] = $permission->title;
                }
                $view->with('permissionsTitle', $permissionsTitle);
            }

        }

        $view->with('appSetting', $appSetting);
    }

    private function lang(View $view)
    {
        $lang = LaravelLocalization::getCurrentLocale();

        $view->with('lang', $lang);
    }

    private function notificationsBar(View $view)
    {
        if (auth()->user()) {
            $user = auth()->user();
            $notificationsBar = Notification::where('notification_to', $user->id)->Unread()->latest()->get();
            
        

            $view->with('notificationsBar', $notificationsBar);
        }

    }
}
