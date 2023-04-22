<?php

namespace App\Http\Middleware;

use App\Models\PermissionRole;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class SMAuthGateMW
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next): mixed
    {
        if (Auth::user()?->role->slug == 'admin') {
            Gate::before(function () {
                return true;
            });
        } else if (Auth::user()) {
            $role_id = Auth::user()?->role_id ?? null;
            $cacheAllocatedPermissions = PermissionRole::leftJoin('permissions', function ($query) {
                $query->on('permission_roles.permission_id', '=', 'permissions.id');
            })->where('permission_roles.role_id', $role_id)
                ->select([
                    DB::raw('permission_roles.permission_id as permission_id'),
                    DB::raw('permissions.permission_key as permission_key'),
                    DB::raw('permission_roles.role_id as role_id'),
                ])
                ->get();
            foreach ($cacheAllocatedPermissions as $allocatedPermission) {
                Gate::define($allocatedPermission->permission_key, function () {
                    return true;
                });
            }
        }
        return $next($request);
    }
}
