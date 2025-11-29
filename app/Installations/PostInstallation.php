<?php
namespace Modules\LogManagement\Installations;

use Nwidart\Modules\Facades\Module;
use Illuminate\Support\Facades\Artisan;

class PostInstallation
{
	public function handle(string $moduleName)
	{
		try {
			$mdoule = Module::find($moduleName);
			$module->enable();

			Artisan::call("migrate", ["--force" => true]);
		} catch (\Exception $e) {
			logger()->error(
				"Failed to run post installation of Log Management: " . $e->getMessage()
			);

			throw $e;
		}
	}
}
