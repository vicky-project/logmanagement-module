<?php

namespace Modules\LogManagement\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Modules\LogManagement\Constants\Permissions;

class ViewAppLogMiddleware
{
	/**
	 * Handle an incoming request.
	 */
	public function handle(Request $request, Closure $next)
	{
		if (
			Auth::check() &&
			Auth::user()->hasPermissionTo(Permissions::VIEW_APPLOG)
		) {
			return $next($request);
		}

		abort(401, "Unauthorized");
	}
}
