<?php

namespace App\Http\Middleware;

use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Middleware;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

use function PHPUnit\Framework\isEmpty;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that's loaded on the first page visit.
     *
     * @see https://inertiajs.com/server-side-setup#root-template
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determines the current asset version.
     *
     * @see https://inertiajs.com/asset-versioning
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    /**
     * Defines the props that are shared by default.
     *
     * @see https://inertiajs.com/shared-data
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function share(Request $request): array
    {
        $roles = ['name' => array(), 'display_name' => array()];
        $permissions_personal = ['name' => array(), 'display_name' => array()];
        $permissions_all = ['name' => array(), 'display_name' => array()];

        if (Auth::user()) {

            $user = User::find(Auth::id());

            foreach ($user->roles as $role) {
                array_push($roles['name'], $role->name);
                array_push($roles['display_name'], $role->display_name);
            }
            foreach ($user->permissions as $permission) {
                array_push($permissions_personal['name'], $permission->name);
                array_push($permissions_personal['display_name'], $permission->display_name);
            }
            foreach ($user->allPermissions() as $allPermission) {
                array_push($permissions_all['name'], $allPermission->name);
                array_push($permissions_all['display_name'], $allPermission->display_name);
            }
        }


        return array_merge(parent::share($request), [
            'appName' => config('app.name'),
            'laravelVersion' => Application::VERSION,
            'phpVersion' => PHP_VERSION,

            'flash' => [
                'message' => $request->session()->get('message'),
            ],

            'canLogin' => Route::has('login'),
            'canRegister' => Route::has('register'),

            'user_rp' => [
                'roles' => $roles,
                'permissions_personal' => $permissions_personal,
                'permissions_all' => $permissions_all,
            ],
        ]);
    }
}
