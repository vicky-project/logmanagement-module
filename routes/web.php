<?php

use Illuminate\Support\Facades\Route;
use Modules\LogManagement\Http\Controllers\ActivitylogController;
use Modules\LogManagement\Http\Controllers\AuthlogController;

Route::middleware(["auth", "web"])
	->prefix("admin")
	->name("logmanagement.")
	->group(function () {
		Route::get("activitylog", ActivitylogController::class)->name(
			"activitylog"
		);
		Route::prefix("authlog")
			->name("authlog.")
			->group(function () {
				Route::get("authlog", [AuthlogController::class, "index"])->name(
					"index"
				);
				Route::get("authlog/{auth_log}", [
					AuthlogController::class,
					"show",
				])->name("show");
			});
	});
