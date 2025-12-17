<?php

namespace Modules\LogManagement\Providers;

use Modules\LogManagement\Constants\Permissions;
use Modules\MenuManagement\Interfaces\MenuProviderInterface;

class MenuProvider implements MenuProviderInterface
{
	/**
	 * Get Menu for LogManagement Module.
	 */
	public static function getMenus(): array
	{
		return [
			[
				"id" => "log-management",
				"name" => "Log Management",
				"icon" => "bug",
				"order" => 3,
				"type" => "group",
				"role" => ["admin"],
				"children" => [
					[
						"id" => "activity-log",
						"name" => "Activity Log",
						"route" => "logmanagement.activitylog",
						"icon" => "user-clock",
						"order" => 1,
						"role" => ["admin"],
						"permission" => Permissions::VIEW_ACTIVITYLOG,
					],
					[
						"id" => "auth-log",
						"name" => "Auth Log",
						"route" => "logmanagement.authlog.index",
						"icon" => "room",
						"order" => 1,
						"role" => ["admin"],
						"permission" => Permissions::VIEW_AUTHLOG,
					],
					[
						"id" => "app-log",
						"name" => "App Log",
						"route" => "log-viewer.index",
						"icon" => "font",
						"order" => 1,
						"role" => [],
						"permission" => Permissions::VIEW_APPLOG,
					],
				],
			],
		];
	}
}
