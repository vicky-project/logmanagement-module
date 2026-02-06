<?php
namespace Modules\LogManagement\Providers\Menu;

use Modules\LogManagement\Constants\Permissions;
use Modules\MenuManagement\Providers\BaseMenuProvider;

class LogMenuProvider extends BaseMenuProvider
{
	protected array $config = [
		"group" => "server",
		"location" => "sidebar",
		"icon" => "bi bi-server",
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
			$this->item([
				"title" => "Log Management",
				"icon" => "bi bi-bug",
				"type" => "dropdown",
				"order" => 20,
				"children" => [
					$this->item([
						"title" => "Activity Log",
						"icon" => "bi bi-person-lines-fill",
						"route" => "logmanagement.activitylog",
						"order" => 1,
						"'permission" => Permissions::VIEW_ACTIVITYLOG,
					]),
					$this->item([
						"title" => "Auth Log",
						"icon" => "bi bi-person-check",
						"route" => "logmanagement.authlog.index",
						"order" => 2,
						"permission" => Permissions::VIEW_AUTHLOG,
					]),
					$this->item([
						"title" => "App Log",
						"icon" => "bi bi-app",
						"route" => "log-viewer.index",
						"order" => 3,
						"permission" => Permissions::VIEW_APPLOG,
					]),
				],
			]),
		];
	}
}
