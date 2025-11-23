<?php

namespace Modules\LogManagement\Constants;

class Permissions
{
	const VIEW_ACTIVITYLOG = "logmanagement.activity.view";
	const CLEAN_ACTIVITYLOG = "logmanagement.clean";

	const VIEW_AUTHLOG = "logmanagement.auth.view";

	const VIEW_APPLOG = "logmanagement.applog.view";

	public static function all(): array
	{
		return [
			self::VIEW_ACTIVITYLOG => "View log user activity",
			self::CLEAN_ACTIVITYLOG => "Clean log user activity",
			self::VIEW_AUTHLOG => "View log user authentication",
			self::VIEW_APPLOG => "View log application",
		];
	}
}
