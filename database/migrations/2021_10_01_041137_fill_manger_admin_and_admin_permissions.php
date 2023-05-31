<?php
use App\Models\Users\MangerAdmin;
use Carbon\Carbon;
use Illuminate\Config\Repository;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;


class FillMangerAdminAndAdminPermissions extends Migration
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
        $this->guardName = config('manger-auth.defaults.guard');
        $providerName = config('auth.guards.' . $this->guardName . '.provider');
        $provider = config('auth.providers.' . $providerName);
        if ($provider['driver'] === 'eloquent') {
            $this->userClassName = $provider['model'];
        }
        $this->userTable = (new $this->userClassName)->getTable();

        $defaultPermissions = collect([
            // view admin as a whole
            'manger',

            // manage translations
            'manger.translation.index',
            'manger.translation.edit',
            'manger.translation.rescan',

            // manage users (access)

            'manger.employee-admin.index',
            'manger.employee-admin.create',
            'manger.employee-admin.edit',
            'manger.employee-admin.delete',
            'manger.employee-admin.impersonal-login',


            'manger.shipper-admin.index',
            'manger.shipper-admin.create',
            'manger.shipper-admin.edit',
            'manger.shipper-admin.delete',
            'manger.shipper-admin.impersonal-login',

            'manger.account-admin.index',
            'manger.account-admin.create',
            'manger.account-admin.edit',
            'manger.account-admin.delete',
            'manger.account-admin.impersonal-login',

// ability to upload
            'manger.upload',

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
                'name' => 'Manger',
                'guard_name' => $this->guardName,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'permissions' => $defaultPermissions->reject(function ($permission) {
                    return $permission === 'manger.manger-admin.impersonal-login';
                }),
            ],
        ];

        //Add new users
        $this->users = [
            [
                'first_name' => 'Manger',
                'last_name' => 'Admin',
                'email' => 'manger@brackets.sk',
                'password' => Hash::make($this->password),
                'remember_token' => null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'activated' => true,
                'roles' => [
                    [
                        'name' => 'Manger',
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

                    MangerAdmin::find($userId)->addMedia(storage_path() . '/images/avatar.png')
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
                    MangerAdmin::find($userItem->id)->media()->delete();
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
