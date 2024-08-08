<?php

namespace App\Policies;

use App\Models\Company_work;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class ClientPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {

    }

    public function checkType(User $user, $type)
    {
        $companyId = $user->is_company ? $user->id : $user->company_id;
        $user_types = Company_work::where('company_id', $companyId)->pluck('work')->toArray();
        return in_array($type, $user_types);

    }

    public function checkTypeDelegateCreate(User $user, $type)
    {
        $companyId = $user->is_company ? $user->id : $user->company_id;
        $user_types = Company_work::where('company_id', $companyId)->pluck('work')->toArray();
        if ($type == null) {
            return in_array(1, $user_types) || in_array(2, $user_types) || in_array(4, $user_types);
        } 
        else {
            return in_array($type, $user_types);

        }

    }

    public function showCleintCompany(User $user, User $client)
    {
        return $user->company_id === $client->company_id;
    }

    public function editCleintCompany(User $user, User $client)
    {
        return $user->company_id === $client->company_id;
    }

    public function deleteCleintCompany(User $user, User $client)
    {
        return $user->company_id === $client->company_id;
    }

    public function showDelegateCompany(User $user, User $delegate)
    {
        return $user->company_id === $delegate->company_id;
    }

    // for Super
    public function showDelegateSupervisor(User $user, User $delegate)
    {
        $delegates = $user->SupervisorDelegate()->get();
        $Arraydelegates = $delegates->pluck('delegate_id')->toArray();
        $delegate = User::where('user_type', 'delegate')->whereIn('id', $Arraydelegates)->first();
        if ($delegate) {
            return true;
        }
    }

    public function showDelegateServiceProvider(User $user, User $delegate)
    {
        $delegates = $user->SupervisorDelegate()->get();
        $Arraydelegates = $delegates->pluck('delegate_id')->toArray();
        $delegate = User::where('user_type', 'delegate')->whereIn('id', $Arraydelegates)->first();
        if ($delegate) {
            return true;
        }
    }
}
