<?php

return [
	"name" => "LogManagement",

	"log_retention_days" => 30,

	"auth_log" => [
		"enabled" => true,
		"retention_days" => 90,
		"hooks" => [
			"enabled" => true,
			"name" => "devices",
			"service" => \Modules\Core\Services\HookService::class,
		],
	],

	"file_logs" => [
		"enabled" => true,
		"allowed_files" => ["laravel.log", "auth.log"],
	],
];
