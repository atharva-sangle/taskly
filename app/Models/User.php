<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
   
    use Notifiable;
   

    protected $fillable = [
        'name',
        'email',
        'password',
        'currant_workspace',
        'avatar',
        'type',
        'plan',
        'plan_expire_date',
        'payment_subscription_id',
        'is_trial_done',
        'is_plan_purchased',
        'interested_plan_id',
        'is_register_trial',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getGuard()
    {
        return $this->guard;
    }

    public function workspace()
    {
        return $this->belongsToMany('App\Models\Workspace', 'user_workspaces', 'user_id', 'workspace_id')->withPivot('permission');
    }

    public function currentWorkspace()
    {
        return $this->hasOne('App\Models\Workspace', 'id', 'currant_workspace');
    }

    public function countProject($workspace_id = '')
    {
        $count = UserProject::join('projects', 'projects.id', '=', 'user_projects.project_id')->where('user_projects.user_id', '=', $this->id);
        if(!empty($workspace_id))
        {
            $count->where('projects.workspace', '=', $workspace_id);
        }

        return $count->count();
    }

    public function countWorkspaceProject($workspace_id)
    {
        return Project::join('workspaces', 'workspaces.id', '=', 'projects.workspace')->where('workspaces.id', '=', $workspace_id)->count();
    }

    public function countWorkspace()
    {
        return Workspace::where('created_by', '=', $this->id)->count();
    }

    public function countUsers($workspace_id)
    {
        $count = UserWorkspace::join('workspaces', 'workspaces.id', '=', 'user_workspaces.workspace_id');
        if(!empty($workspace_id))
        {
            $count->where('workspaces.id', '=', $workspace_id);
        }
        else
        {
            $count->whereIn(
                'workspaces.id', function ($query){
                $query->select('workspace_id')->from('user_workspaces')->where('permission', '=', 'Owner')->where('user_id', '=', $this->id);
            }
            );
        }

        return $count->count();
    }

    public function countClients($workspace_id)
    {
        $count = ClientWorkspace::join('workspaces', 'workspaces.id', '=', 'client_workspaces.workspace_id');
        if(!empty($workspace_id))
        {
            $count->where('workspaces.id', '=', $workspace_id);
        }
        else
        {
            $count->whereIn(
                'workspaces.id', function ($query){
                $query->select('workspace_id')->from('user_workspaces')->where('permission', '=', 'Owner')->where('user_id', '=', $this->id);
            }
            );
        }

        return $count->count();
    }

    public function countTask($workspace_id)
    {
        return Task::join('projects', 'tasks.project_id', '=', 'projects.id')->where('projects.workspace', '=', $workspace_id)->where('tasks.assign_to', '=', $this->id)->count();
    }

    public function getPlan()
    {
        return $this->hasOne('App\Models\Plan', 'id', 'plan');
    }

    public function assignPlan($planID, $frequency = '')
    {
        $plan = Plan::find($planID);
        if($plan)
        {
            $workspaces      = Workspace::where('created_by', '=', $this->id)->get();
            $workspacesCount = 0;
            foreach($workspaces as $workspace)
            {
                $workspacesCount++;
                $workspace->is_active = $plan->max_workspaces != -1 || $workspacesCount <= $plan->max_workspaces ? 1 : 0;
                $workspace->save();

                $projectCount = 0;
                foreach($workspace->projects as $project)
                {
                    $projectCount++;
                    $project->is_active = $plan->max_projects == -1 || $projectCount <= $plan->max_projects ? 1 : 0;
                    $project->save();
                }

                $userWorkspaces      = UserWorkspace::where('workspace_id', '=', $workspace->id)->get();
                $userWorkspacesCount = 0;
                foreach($userWorkspaces as $userWorkspace)
                {
                    $userWorkspacesCount++;
                    $userWorkspace->is_active = $plan->max_users == -1 || $userWorkspacesCount <= $plan->max_users ? 1 : 0;
                    $userWorkspace->save();

                    UserProject::join('projects', 'projects.id', '=', 'user_projects.project_id')->where('projects.workspace', '=', $workspace->id)->where('user_projects.user_id', '=', $userWorkspace->user_id)->update(['user_projects.is_active' => $userWorkspace->is_active]);
                }

                $clientWorkspaces      = ClientWorkspace::where('workspace_id', '=', $workspace->id)->get();
                $clientWorkspacesCount = 0;
                foreach($clientWorkspaces as $clientWorkspace)
                {
                    $clientWorkspacesCount++;
                    $clientWorkspace->is_active = $plan->max_clients == -1 || $clientWorkspacesCount <= $plan->max_clients ? 1 : 0;
                    $clientWorkspace->save();

                    ClientProject::join('projects', 'projects.id', '=', 'client_projects.project_id')->where('projects.workspace', '=', $workspace->id)->where('client_projects.client_id', '=', $clientWorkspace->client_id)->update(['client_projects.is_active' => $clientWorkspace->is_active]);
                }
            }

            $this->plan = $plan->id;
            if($frequency == 'weekly')
            {
                $this->plan_expire_date = Carbon::now()->addWeeks(1)->isoFormat('YYYY-MM-DD');
            }
            elseif($frequency == 'monthly')
            {
                $this->plan_expire_date = Carbon::now()->addMonths(1)->isoFormat('YYYY-MM-DD');
            }
            elseif($frequency == 'annual')
            {
                $this->plan_expire_date = Carbon::now()->addYears(1)->isoFormat('YYYY-MM-DD');
            }
            else
            {
                $this->plan_expire_date = null;
            }
            $this->save();

            return ['is_success' => true];
        }
        else
        {
            return [
                'is_success' => false,
                'error' => __('Plan is deleted.'),
            ];
        }
    }

    public function cancel_subscription($user_id = false)
    {
        $paymentSetting = Utility::getAdminPaymentSetting();
        $user           = User::find($user_id);

        if(!$user_id && !$user && $user->payment_subscription_id != '' && $user->payment_subscription_id != null)
        {
            return true;
        }

        $data            = explode('###', $user->payment_subscription_id);
        $type            = strtolower($data[0]);
        $subscription_id = $data[1];

        switch($type)
        {
            case 'stripe':

                /* Initiate Stripe */ \Stripe\Stripe::setApiKey($paymentSetting['stripe_secret']);

                /* Cancel the Stripe Subscription */
                $subscription = \Stripe\Subscription::retrieve($subscription_id);
                $subscription->cancel();

                break;

            case 'paypal':

                /* Initiate paypal */ $paypal = new \PayPal\Rest\ApiContext(new \PayPal\Auth\OAuthTokenCredential($paymentSetting['paypal_client_id'], $paymentSetting['paypal_secret_key']));
                $paypal->setConfig(['mode' => $paymentSetting['paypal_mode']]);

                /* Create an Agreement State Descriptor, explaining the reason to suspend. */
                $agreement_state_descriptior = new \PayPal\Api\AgreementStateDescriptor();
                $agreement_state_descriptior->setNote('Suspending the agreement');

                /* Get details about the executed agreement */
                $agreement = \PayPal\Api\Agreement::get($subscription_id, $paypal);

                /* Suspend */
                $agreement->suspend($agreement_state_descriptior, $paypal);

                break;
        }

        $user->payment_subscription_id = '';
        $user->save();
    }

    public function unread($workspace_id, $user_id)
    {
        return ChMessage::where('from_id', '=', $this->id)->where('to_id', '=', $user_id)->where('seen', '=', 0)->where('workspace_id', '=', $workspace_id)->get();
    }

    public function notifications($workspace_id)
    {
        return Notification::where('user_id', '=', $this->id)->where('workspace_id', '=', $workspace_id)->where('is_read', '=', 0)->orderBy('id', 'desc')->get();
    }

    public function getInvoices($workspace_id)
    {
        return Invoice::where('workspace_id', '=', $workspace_id)->get();
    }

    public function getPermission($project_id)
    {
        $data = UserProject::where('user_id', '=', $this->id)->where('project_id', '=', $project_id)->first();

        return json_decode($data->permission, true);
    }

}
