<?php
namespace Modules\LogManagement\Traits;

use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\CausesActivity;
use Rappasoft\LaravelAuthenticationLog\Traits\AuthenticationLoggable;

trait UserLog
{
	use CausesActivity, LogsActivity, AuthenticationLoggable;

	/**
	 * Activity Log Options
	 */
	public function getActivitylogOptions(): LogOptions
	{
		return LogOptions::defaults()
			->logOnly(["name", "email", "is_active"])
			->logOnlyDirty()
			->dontSubmitEmptyLogs()
			->setDescriptionForEvent(fn(string $eventName) => "User {$eventName}")
			->useLogName("users");
	}

	/**
	 * One-to-Many: User has many Activities (via Spatie Activitylog)
	 */
	public function activities()
	{
		return $this->hasMany(
			\Spatie\Activitylog\Models\Activity::class,
			"causer_id"
		);
	}

	public function getLastActivityAttribute()
	{
		return $this->activities()
			->latest()
			->first();
	}
}
