<?php

namespace Modules\LogManagement\Services;

use Modules\LogManagement\Models\ActivityLog;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\Builder;

class ActivityLogService
{
	/**
	 * Get available causers for filtering.
	 */
	public function getAvailableCausers(): Collection
	{
		$cacheKey = "activitylog_ui.causers";

		return Cache::remember($cacheKey, 3600, function () {
			return ActivityLog::select("causer_type", "causer_id")
				->whereNotNull("causer_type")
				->whereNotNull("causer_id")
				->with("causer")
				->distinct()
				->get()
				->filter(function ($activity) {
					return $activity->causer !== null;
				})
				->map(function ($activity) {
					return [
						"id" => $activity->causer_id,
						"type" => $activity->causer_type,
						"name" => $activity->causer_name,
						"label" =>
							$activity->causer_name .
							" (" .
							class_basename($activity->causer_type) .
							")",
					];
				})
				->unique("id")
				->values();
		});
	}

	/**
	 * Get available subject types for filtering.
	 */
	public function getAvailableSubjectTypes(): Collection
	{
		$cacheKey = "activitylog_ui.subject_types";

		return Cache::remember($cacheKey, 3600, function () {
			return ActivityLog::select("subject_type")
				->whereNotNull("subject_type")
				->distinct()
				->pluck("subject_type")
				->map(function ($type) {
					return [
						"value" => $type,
						"label" => class_basename($type),
						"full_name" => $type,
					];
				})
				->values();
		});
	}

	/**
	 * Get available event types for filtering.
	 */
	public function getAvailableEventTypes(): Collection
	{
		$cacheKey = "activitylog_ui.event_types";

		return Cache::remember($cacheKey, 3600, function () {
			return ActivityLog::select("event")
				->whereNotNull("event")
				->distinct()
				->pluck("event")
				->map(function ($event) {
					return [
						"value" => $event,
						"label" => ucfirst($event),
					];
				})
				->values();
		});
	}

	public function getActivities(array $filters = [])
	{
		$query = ActivityLog::query()
			->with(["causer", "subject"])
			->latest("id");

		return $this->applyFilters($query, $filters);
	}

	public function applyFilters(Builder $query, array $filters): Builder
	{
		if (!empty($filters["search"])) {
			$query->search($filters["search"]);
		}

		if (
			!empty($filters["date_preset"]) &&
			$filters["date_preset"] !== "custom"
		) {
			$query->datePreset($filters["date_preset"]);
		} elseif (!empty($filters["start_date"]) || !empty($filters["end_date"])) {
			$query->dateRange(
				$filters["start_date"] ?? null,
				$filters["end_date"] ?? null
			);
		}

		if (!empty($filters["causer_type"]) || !empty($filters["causer_id"])) {
			$causerId =
				isset($filters["causer_id"]) && $filters["causer_id"] !== ""
					? (is_numeric($filters["causer_id"])
						? (int) $filters["causer_id"]
						: $filters["causer_id"])
					: null;

			$query->byCauser($filters["causer_type"] ?? null, $causerId);
		}

		if (!empty($filters["subject_type"]) || !empty($filters["subject_id"])) {
			$subjectId =
				isset($filters["subject_id"]) && $filters["subject_id"] !== ""
					? (is_numeric($filters["subject_id"])
						? (int) $filters["subject_id"]
						: $filters["subject_id"])
					: null;
			$query->bySubject($filters["subject_type"] ?? null, $subjectId);
		}

		// Event type filters
		if (!empty($filters["event_types"]) && is_array($filters["event_types"])) {
			$query->byEventTypes($filters["event_types"]);
		}

		// Property filters
		if (!empty($filters["property_key"])) {
			$query->whereJsonContains("properties", [
				$filters["property_key"] => null,
			]);
		}

		return $query;
	}
}
