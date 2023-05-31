<?php

use App\Models\Users\CeoAdmin;
use Carbon\Carbon;
use Illuminate\Config\Repository;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

/**
 * Class FillDefaultAdminUserAndPermissions
 */
class FillCeoAdminAndAdminPermissions extends Migration
{
    /**
     * @var Repository|mixed
     */
    protected $guardName;
    /**
     * @var mixed
     */
    protected $userClassName;
    /**
     * @var
     */
    protected $userTable;

    /**
     * @var array
     */
    protected $permissions;
    /**
     * @var array
     */
    protected $roles;
    /**
     * @var array
     */
    protected $users;

    /**
     * @var string
     */
    protected $password = 'x9FL3Lk621';

    /**
     * FillDefaultAdminUserAndPermissions constructor.
     */
    public function __construct()
    {
        $this->guardName = config('ceo-auth.defaults.guard');
        $providerName = config('auth.guards.' . $this->guardName . '.provider');
        $provider = config('auth.providers.' . $providerName);
        if ($provider['driver'] === 'eloquent') {
            $this->userClassName = $provider['model'];
        }
        $this->userTable = (new $this->userClassName)->getTable();

        $defaultPermissions = collect([
            // view admin as a whole
            'ceo',

            // manage translations
            'ceo.translation.index',
            'ceo.translation.edit',
            'ceo.translation.rescan',

            // manage users (access)
            'ceo.agent-admin.index',
            'ceo.agent-admin.create',
            'ceo.agent-admin.edit',
            'ceo.agent-admin.delete',
            'ceo.agent-admin.impersonal-login',

            'ceo.manger-admin.index',
            'ceo.manger-admin.create',
            'ceo.manger-admin.edit',
            'ceo.manger-admin.delete',
            'ceo.manger-admin.impersonal-login',

            'ceo.employee-admin.index',
            'ceo.employee-admin.create',
            'ceo.employee-admin.edit',
            'ceo.employee-admin.delete',
            'ceo.employee-admin.impersonal-login',

            'ceo.seo-admin.index',
            'ceo.seo-admin.create',
            'ceo.seo-admin.edit',
            'ceo.seo-admin.delete',
            'ceo.seo-admin.impersonal-login',

            'ceo.shipper-admin.index',
            'ceo.shipper-admin.create',
            'ceo.shipper-admin.edit',
            'ceo.shipper-admin.delete',
            'ceo.shipper-admin.impersonal-login',

            'ceo.account-admin.index',
            'ceo.account-admin.create',
            'ceo.account-admin.edit',
            'ceo.account-admin.delete',
            'ceo.account-admin.impersonal-login',

// ability to upload
            'ceo.upload',

        ]);

        //Add new permissions
        $this->permissions = $defaultPermissions->map(function ($permission) {
            return [
                'name' => $permission,
                'guard_name' => $this->guardName,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ];
        })->toArray();

        //Add new roles
        $this->roles = [
            [
                'name' => 'Ceo',
                'guard_name' => $this->guardName,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'permissions' => $defaultPermissions->reject(function ($permission) {
                    return $permission === 'ceo.ceo-admin.impersonal-login';
                }),
            ],
        ];

        //Add new users
        $this->users = [
            [
                'first_name' => 'Ceo',
                'last_name' => 'Admin',
                'email' => 'ceo@brackets.sk',
                'password' => Hash::make($this->password),
                'remember_token' => null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'activated' => true,
                'roles' => [
                    [
                        'name' => 'Ceo',
                        'guard_name' => $this->guardName,
                    ],
                ],
                'permissions' => [
                    //
                ],
            ],
        ];
    }

    /**
     * Run the migrations.
     *
     * @return void
     * @throws Exception
     */
    public function up(): void
    {
        if ($this->userClassName === null) {
            throw new RuntimeException('Admin user model not defined');
        }
        DB::transaction(function () {
            foreach ($this->permissions as $permission) {
                $permissionItem = DB::table('permissions')->where([
                    'name' => $permission['name'],
                    'guard_name' => $permission['guard_name']
                ])->first();
                if ($permissionItem === null) {
                    DB::table('permissions')->insert($permission);
                }
            }

            foreach ($this->roles as $role) {
                $permissions = $role['permissions'];
                unset($role['permissions']);

                $roleItem = DB::table('roles')->where([
                    'name' => $role['name'],
                    'guard_name' => $role['guard_name']
                ])->first();
                if ($roleItem === null) {
                    $roleId = DB::table('roles')->insertGetId($role);
                } else {
                    $roleId = $roleItem->id;
                }

                $permissionItems = DB::table('permissions')
                    ->whereIn('name', $permissions)
                    ->where(
                        'guard_name',
                        $role['guard_name']
                    )->get();
                foreach ($permissionItems as $permissionItem) {
                    $roleHasPermissionData = [
                        'permission_id' => $permissionItem->id,
                        'role_id' => $roleId
                    ];
                    $roleHasPermissionItem = DB::table('role_has_permissions')->where($roleHasPermissionData)->first();
                    if ($roleHasPermissionItem === null) {
                        DB::table('role_has_permissions')->insert($roleHasPermissionData);
                    }
                }
            }

            foreach ($this->users as $user) {
                $roles = $user['roles'];
                unset($user['roles']);

                $permissions = $user['permissions'];
                unset($user['permissions']);

                $userItem = DB::table($this->userTable)->where([
                    'email' => $user['email'],
                ])->first();

                if ($userItem === null) {
                    $userId = DB::table($this->userTable)->insertGetId($user);

                    CeoAdmin::find($userId)->addMedia(storage_path() . '/images/avatar.png')
                        ->preservingOriginal()
                        ->toMediaCollection('avatar', 'media');

                    foreach ($roles as $role) {
                        $roleItem = DB::table('roles')->where([
                            'name' => $role['name'],
                            'guard_name' => $role['guard_name']
                        ])->first();

                        $modelHasRoleData = [
                            'role_id' => $roleItem->id,
                            'model_id' => $userId,
                            'model_type' => $this->userClassName
                        ];
                        $modelHasRoleItem = DB::table('model_has_roles')->where($modelHasRoleData)->first();
                        if ($modelHasRoleItem === null) {
                            DB::table('model_has_roles')->insert($modelHasRoleData);
                        }
                    }

                    foreach ($permissions as $permission) {
                        $permissionItem = DB::table('permissions')->where([
                            'name' => $permission['name'],
                            'guard_name' => $permission['guard_name']
                        ])->first();

                        $modelHasPermissionData = [
                            'permission_id' => $permissionItem->id,
                            'model_id' => $userId,
                            'model_type' => $this->userClassName
                        ];
                        $modelHasPermissionItem = DB::table('model_has_permissions')->where($modelHasPermissionData)->first();
                        if ($modelHasPermissionItem === null) {
                            DB::table('model_has_permissions')->insert($modelHasPermissionData);
                        }
                    }
                }
            }
        });
        app()['cache']->forget(config('permission.cache.key'));
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     * @throws Exception
     */
    public function down(): void
    {
        if ($this->userClassName === null) {
            throw new RuntimeException('Admin user model not defined');
        }
        DB::transaction(function () {
            foreach ($this->users as $user) {
                $userItem = DB::table($this->userTable)->where('email', $user['email'])->first();
                if ($userItem !== null) {
                    CeoAdmin::find($userItem->id)->media()->delete();
                    DB::table($this->userTable)->where('id', $userItem->id)->delete();
                    DB::table('model_has_permissions')->where([
                        'model_id' => $userItem->id,
                        'model_type' => $this->userClassName
                    ])->delete();
                    DB::table('model_has_roles')->where([
                        'model_id' => $userItem->id,
                        'model_type' => $this->userClassName
                    ])->delete();
                }
            }

            foreach ($this->roles as $role) {
                $roleItem = DB::table('roles')->where([
                    'name' => $role['name'],
                    'guard_name' => $role['guard_name']
                ])->first();
                if ($roleItem !== null) {
                    DB::table('roles')->where('id', $roleItem->id)->delete();
                    DB::table('model_has_roles')->where('role_id', $roleItem->id)->delete();
                }
            }

            foreach ($this->permissions as $permission) {
                $permissionItem = DB::table('permissions')->where([
                    'name' => $permission['name'],
                    'guard_name' => $permission['guard_name']
                ])->first();
                if ($permissionItem !== null) {
                    DB::table('permissions')->where('id', $permissionItem->id)->delete();
                    DB::table('model_has_permissions')->where('permission_id', $permissionItem->id)->delete();
                }
            }
        });
        app()['cache']->forget(config('permission.cache.key'));
    }
}
