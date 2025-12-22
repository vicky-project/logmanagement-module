<?php
namespace Modules\LogManagement\Providers\Menu;

use Modules\LogManagement\Constants\Permissions;
use Modules\MenuManagement\Providers\BaseMenuProvider;

class LogMenuProvider extends BaseMenuProvider
{
	protected array $config = [
		"group" => "server",
		"location" => "sidebar",
		"icon" => "fas fa-server",
		"order" => 1,
		"permission" => null,
	];

	public function __construct()
	{
		$moduleName = "LogManagement";
		parent::__construct($moduleName);
	}

	/**
	 * Get all menus
	 */
	public function getMenus(): array
	{
		return [
			$thi->item([
				"tìtle" => "Log Management",
				"icon" => "fas fa-bug",
				"type" => "dropdown",
				"order" => 20,
				"children" => [
					$this->item([
						"title" => "Activity Log",
						"icon" => "fas fa-user-clock",
						"route" => "'logmanagement.activitylog",
						"order" => 1,
						"'permission" => Permissions::VIEW_ACTIVITYLOG,
					]),
					$this->item([
						"title" => "Auth Log",
						"icon" => "fas fa-user-lock",
						"route" => "logmanagement.authlog.index",
						"order" => 2,
						"permission" => Permissions::VIEW_AUTHLOG,
					]),
					$this->item([
						"title" => "App Log",
						"icon" => "fas fa-font",
						"route" => "log-viewer.index",
						"order" => 3,
						"permission" => Permissions::VIEW_APPLOG,
					]),
				],
			]),
		];
	}
}
