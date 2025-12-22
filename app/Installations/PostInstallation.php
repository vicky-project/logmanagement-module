<?php
namespace Modules\LogManagement\Installations;

use Nwidart\Modules\Facades\Module;
use Illuminate\Support\Facades\Artisan;
use Modules\Core\Services\Generators\TraitInserter;

class PostInstallation
{
	public function handle(string $moduleName)
	{
		try {
			$module = Module::find($moduleName);
			$module->enable();

			$result = $this->insertTraits();
			logger()->info($result["message"]);

			Artisan::call("vendor:publish", [
				"--tag" => "log-viewer-assets",
				"--force" => true,
			]);
			Artisan::call("migrate", ["--force" => true]);
		} catch (\Exception $e) {
			logger()->error(
				"Failed to run post installation of Log Management: " . $e->getMessage()
			);

			throw $e;
		}
	}

	private function insertTraits()
	{
		return TraitInserter::insertTrait("Modules\LogManagement\Traits\UserLog");
	}
}
