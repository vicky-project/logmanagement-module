<?php

namespace Modules\LogManagement\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Jenssegers\Agent\Agent;
use Illuminate\Support\Facades\Artisan;
use Rappasoft\LaravelAuthenticationLog\Models\AuthenticationLog;
use Modules\LogManagement\Constants\Permissions;

class AuthlogController extends Controller
{
	public function __construct()
	{
		$this->middleware(["permission:" . Permissions::VIEW_AUTHLOG])->only([
			"index",
			"show",
		]);
	}
	/**
	 * Display a listing of the resource.
	 */
	public function index()
	{
		$logs = AuthenticationLog::latest("login_at")
			->get()
			->map(function ($log) {
				$agent = tap(
					new Agent(),
					fn($agent) => $agent->setUserAgent($log->user_agent)
				);
				return [
					"id" => $log->id,
					"name" => $log->authenticatable ? $log->authenticatable->name : null,
					"email" => $log->authenticatable
						? $log->authenticatable->email
						: null,
					"ip_address" => $log->ip_address,
					"user_agent" => $agent->platform() . " - " . $agent->browser(),
					"location" =>
						$log->location && $log->location["default"] === false
							? $log->location["city"] . ", " . $log->location["state"]
							: "-",
					"login_at" => $log->login_at
						? $log->login_at->format("d-m-Y H:i:s")
						: "-",
					"login_successful" => $log->login_successful,
					"logout_at" => $log->logout_at
						? $log->logout_at->format("d-m-Y H:i:s")
						: "Never",
					"cleared_by_user" => $log->cleared_by_user ? "Yes" : "No",
				];
			});
		return view("logmanagement::logs.auth-log", compact("logs"));
	}

	/**
	 * Show the specified resource.
	 */
	public function show(AuthenticationLog $auth_log)
	{
		return view("logmanagement::logs.show-authlog", compact("auth_log"));
	}

	public function trustedDeviceToggle(Request $request)
	{
		$request->validate([
			"device_id" =>
				"required|string|exists:" .
				config("authentication-log.table_name") .
				",device_id",
		]);

		try {
			$deviceId = $request->device_id;
			$user = \Auth::user();
			$cacheKey = "device_user_" . $user->id . "_trusted_" . md5($deviceId);

			$isTrusted = false;
			if (cache()->has($cacheKey)) {
				$isTrusted = cache()->get($cacheKey);
			} else {
				$isTrusted = $user->isDeviceTrusted($deviceId);
			}

			if ($isTrusted) {
				$user->untrustDevice($deviceId);
				$message = "Success untrust device";
			} else {
				$user->trustDevice($deviceId);
				$message = "Success trust device";
			}

			cache()->forget($cacheKey);

			return response()->json(["success" => true, "message" => $message]);
		} catch (\Exception $e) {
			return response()->json(
				[
					"success" => false,
					"message" => $e->getMessage(),
				],
				500
			);
		}
	}

	/**
	 * Show the form for editing the specified resource.
	 */
	public function edit($id)
	{
		return view("logmanagement::edit");
	}

	/**
	 * Update the specified resource in storage.
	 */
	public function update(Request $request, $id)
	{
	}

	/**
	 * Remove the specified resource from storage.
	 */
	public function destroy($id)
	{
	}
}
