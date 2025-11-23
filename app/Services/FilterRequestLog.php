<?php

namespace Modules\LogManagement\Services;

use Illuminate\Http\Request;

class FilterRequestLog
{
	/**
	 * Extract filters from request.
	 */
	public function getFiltersFromRequest(Request $request): array
	{
		return [
			"search" => $request->get("search"),
			"date_preset" => $request->get("date_preset"),
			"start_date" => $request->get("start_date"),
			"end_date" => $request->get("end_date"),
			"causer_type" => $request->get("causer_type"),
			"causer_id" => $this->sanitizeId($request->get("causer_id")),
			"subject_type" => $request->get("subject_type"),
			"subject_id" => $this->sanitizeId($request->get("subject_id")),
			"event_types" => $this->getArrayFromRequest($request, "event_types"),
			"property_key" => $request->get("property_key"),
		];
	}

	/**
	 * Get array parameter from request, handling both array and single values.
	 */
	private function getArrayFromRequest(Request $request, string $key): array
	{
		$value = $request->get($key);

		if (is_array($value)) {
			return array_filter($value, fn($item) => $item !== null && $item !== "");
		}

		if ($value !== null && $value !== "") {
			return [$value];
		}

		return [];
	}

	/**
	 * Sanitize ID parameter to ensure proper type.
	 */
	private function sanitizeId(mixed $id): ?int
	{
		if ($id === null || $id === "") {
			return null;
		}

		if (is_numeric($id)) {
			return (int) $id;
		}

		return null;
	}

	public function populateJsonData($data)
	{
		return $data
			->map(function ($item) {
				return [
					"event" => $item->event,
					"description" => $item->description ?? "",
					"subject_type" => $item->subject_type,
					"user" => $item->causer->name ?? "",
					"date" => $item->created_at->format("d/m/Y H:i:s"),
					"actions" => "",
				];
			})
			->toArray();
	}
}
