<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AgentAdmin\DestroyAdminUser;
use App\Http\Requests\Admin\AgentAdmin\ImpersonalLoginAdminUser;
use App\Http\Requests\Admin\AgentAdmin\IndexAdminUser;
use App\Http\Requests\Admin\AgentAdmin\StoreAdminUser;
use App\Http\Requests\Admin\AgentAdmin\UpdateAdminUser;
use App\Models\Users\AgentAdmin;
use Spatie\Permission\Models\Role;
use Brackets\AdminAuth\Activation\Facades\Activation;
use Brackets\AdminAuth\Services\ActivationService;
use Brackets\AdminListing\Facades\AdminListing;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Config;
use Illuminate\View\View;

class AgentAdminsController extends Controller
{

    /**
     * Guard used for admin user
     *
     * @var string
     */
    protected $guard = 'admin';

    /**
     * AdminUsersController constructor.
     *
     * @return void
     */
    public function __construct()
    {
        $this->guard = config('admin-auth.defaults.guard');
    }

    /**
     * Display a listing of the resource.
     *
     * @param IndexAdminUser $request
     * @return Factory|View
     */
    public function index(IndexAdminUser $request)
    {
        // create and AdminListing instance for a specific model and
        $data = AdminListing::create(AgentAdmin::class)->processRequestAndGet(
            // pass the request with params
            $request,

            // set columns to query
            ['id', 'first_name', 'last_name', 'email', 'activated', 'forbidden', 'language', 'last_login_at'],

            // set columns to searchIn
            ['id', 'first_name', 'last_name', 'email', 'language']
        );

        if ($request->ajax()) {
            return ['data' => $data, 'activation' => Config::get('agent-auth.activation_enabled')];
        }

        return view('admin.agent-admin.index', ['data' => $data, 'activation' => Config::get('agent-auth.activation_enabled')]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function create()
    {
        $this->authorize('admin.agent-admin.create');

        return view('admin.agent-admin.create', [
            'activation' => Config::get('agent-auth.activation_enabled'),
            'roles' => Role::where('guard_name','agent')->get(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreAdminUser $request
     * @return array|RedirectResponse|Redirector
     */
    public function store(StoreAdminUser $request)
    {
        // Sanitize input
        $sanitized = $request->getModifiedData();

        // Store the AdminUser
        $adminUser = AgentAdmin::create($sanitized);

        // But we do have a roles, so we need to attach the roles to the adminUser
        $adminUser->roles()->sync(collect($request->input('roles', []))->map->id->toArray());

        if ($request->ajax()) {
            return ['redirect' => url('admin/agent-admin'), 'message' => trans('brackets/admin-ui::admin.operation.succeeded')];
        }

        return redirect('admin/agent-admin');
    }

    /**
     * Display the specified resource.
     *
     * @param AgentAdmin $adminUser
     * @throws AuthorizationException
     * @return void
     */
    public function show(AgentAdmin $adminUser)
    {
        $this->authorize('admin.agent-admin.show', $adminUser);

        // TODO your code goes here
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param AgentAdmin $adminUser
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function edit(AgentAdmin $adminUser)
    {
        $this->authorize('admin.agent-admin.edit', $adminUser);

        $adminUser->load('roles');

        return view('admin.agent-admin.edit', [
            'adminUser' => $adminUser,
            'activation' => Config::get('agent-auth.activation_enabled'),
            'roles' => Role::where('guard_name','agent')->get(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateAdminUser $request
     * @param AgentAdmin $adminUser
     * @return array|RedirectResponse|Redirector
     */
    public function update(UpdateAdminUser $request, AgentAdmin $adminUser)
    {
        // Sanitize input
        $sanitized = $request->getModifiedData();

        // Update changed values AdminUser
        $adminUser->update($sanitized);

        // But we do have a roles, so we need to attach the roles to the adminUser
        if ($request->input('roles')) {
            $adminUser->roles()->sync(collect($request->input('roles', []))->map->id->toArray());
        }

        if ($request->ajax()) {
            return ['redirect' => url('admin/agent-admin'), 'message' => trans('brackets/admin-ui::admin.operation.succeeded')];
        }

        return redirect('admin/agent-admin');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param DestroyAdminUser $request
     * @param AgentAdmin $adminUser
     * @throws Exception
     * @return ResponseFactory|RedirectResponse|Response
     */
    public function destroy(DestroyAdminUser $request, AgentAdmin $adminUser)
    {
        $adminUser->delete();

        if ($request->ajax()) {
            return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
        }

        return redirect()->back();
    }

    /**
     * Resend activation e-mail
     *
     * @param Request $request
     * @param ActivationService $activationService
     * @param AgentAdmin $adminUser
     * @return array|RedirectResponse
     */
    public function resendActivationEmail(Request $request, ActivationService $activationService, AgentAdmin $adminUser)
    {
        if (Config::get('agent-auth.activation_enabled')) {
            $response = $activationService->handle($adminUser);
            if ($response == Activation::ACTIVATION_LINK_SENT) {
                if ($request->ajax()) {
                    return ['message' => trans('brackets/admin-ui::admin.operation.succeeded')];
                }

                return redirect()->back();
            } else {
                if ($request->ajax()) {
                    abort(409, trans('brackets/admin-ui::admin.operation.failed'));
                }

                return redirect()->back();
            }
        } else {
            if ($request->ajax()) {
                abort(400, trans('brackets/admin-ui::admin.operation.not_allowed'));
            }

            return redirect()->back();
        }
    }

    /**
     * @param ImpersonalLoginAdminUser $request
     * @param AgentAdmin $adminUser
     * @return RedirectResponse
     * @throws  AuthorizationException
     */
    public function impersonalLogin(ImpersonalLoginAdminUser $request, AgentAdmin $adminUser) {
        Auth::login($adminUser);
        return redirect()->back();
    }

}
