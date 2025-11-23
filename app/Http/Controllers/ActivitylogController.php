<?php

namespace Modules\LogManagement\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\LogManagement\Services\FilterRequestLog;
use Modules\LogManagement\Services\ActivityLogService;
use Modules\LogManagement\Constants\Permissions;

class ActivitylogController extends Controller
{
	protected FilterRequestLog $filterRequestService;
	protected ActivityLogService $activitylogService;

	public function __construct(
		FilterRequestLog $filterRequestService,
		ActivityLogService $activitylogService
	) {
		$this->filterRequestService = $filterRequestService;
		$this->activitylogService = $activitylogService;

		$this->middleware(["permission:" . Permissions::VIEW_ACTIVITYLOG]);
	}
	/**
	 * Display a listing of the resource.
	 */
	public function __invoke(Request $request)
	{
		$filters = $this->filterRequestService->getFiltersFromRequest($request);

		// Get filter options
		$filterOptions = [
			"causers" => $this->activitylogService->getAvailableCausers(),
			"subject_types" => $this->activitylogService->getAvailableSubjectTypes(),
			"event_types" => $this->activitylogService->getAvailableEventTypes(),
			"date_presets" => [
				"all" => "All time",
				"today" => "Today",
				"yesterday" => "Yesterday",
				"last_7_days" => "Last 7 days",
				"last_30_days" => "Last 30 days",
				"this_month" => "This month",
				"last_month" => "Last month",
				"custom" => "Custom range",
			],
		];

		$data = $this->activitylogService->getActivities($filters)->get();

		return $request->wantsJson()
			? response()->json([
				"data" => $this->filterRequestService->populateJsonData($data),
			])
			: view(
				"logmanagement::logs.activity-log",
				compact("filterOptions", "data", "filters")
			);
	}
}
