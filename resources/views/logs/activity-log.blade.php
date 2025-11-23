@extends('viewmanager::layouts.app')

@section('page-title', 'Activity Log')

@section('content')
<div class="row">
  <div class="col col-lg-4">
    <div class="card mb-4">
      <div class="card-header">
        <h5 class="card-title">Filters</h5>
      </div>
      <div class="card-body">
        <form action="" id="filters-form">
          <div class="row px-2">
            <div class="mb-3">
              <label class="form-label">Search</label>
              <input type="text" class="form-control" name="search" placeholder="Search activities, users, descriptions..." value="{{ $filters['search'] ?? ''}}">
            </div>
          </div>
          <div class="row mt-4 pt-2 border-top border-info px-2">
            <div class="col mb-3">
              <label class="form-label">Date Range</label>
              <div class="row">
                @foreach($filterOptions["date_presets"] as $key => $date)
                  @if($key === "custom")
                  <div class="col-6 my-2">
                    <input type="radio" class="btn-check" name="date_preset" value="{{$key}}" id="date-range-{{$key}}" autocomplete="off" @checked($filters["date_preset"] === $key)>
                    <label class="btn btn-outline-success" for="date-range-{{$key}}">{{$date}}</label>
                  </div>
                  @continue
                  @endif
                  <div class="col-6 my-2">
                    <input type="radio" class="btn-check" name="date_preset" value="{{$key}}" id="date-range-{{$key}}" autocomplete="off" @checked($filters["date_preset"] === $key)>
                    <label class="btn btn-outline-success" for="date-range-{{$key}}">{{$date}}</label>
                </div>
                @endforeach
              </div>
              <div class="row @if($filters['end_date'] !== 'custom') d-none @endif" id="date-range">
                <div class="col-sm-6 mb-3 mb-sm-0">
                  <input type="date" id="start_date" name="start_date" value="{{$filters['start_date']}}" class="form-control" placeholder="start date..." max="{{date('Y-m-d')}}">
                </div>
                <div class="col-sm-6 mb-3 mb-sm-0">
                  <input type="date" id="end_date" name="end_date" value="{{$filters['end_date']}}" class="form-control" placeholder="end date..." max="{{date('Y-m-d')}}">
                </div>
              </div>
            </div>
          </div>
          <div class="row mt-4 p-2 border-top border-info px-2">
            <div class="col-6 mb-3">
              <label class="form-label">Event Types</label>
              @foreach($filterOptions["event_types"] as $type)
                <div class="form-check form-switch form-switch-xl">
                  <input class="form-check-input" type="checkbox" id="event-{{$type['value']}}" name="event_types[]" value="{{$type['value']}}" @checked(in_array($type['value'], $filters['event_types']))>
                  <label class="form-check-label" for="event-{{$type['value']}}">{{$type["label"]}}</label>
                </div>
              @endforeach
            </div>
            <div class="col-6 mb-3">
              <select class="form-select form-select-lg mb-3" aria-label=".form-select-lg example">
                <option value="">All Users</option>
                @foreach($filterOptions["causers"] as $causer)
                  <option value="{{$causer['id']}}" @selected($filters['causer_id'] === $causer['id'])>{{$causer['name']}}</option>
                @endforeach
              </select>
            </div>
          </div>
          <div class="row pt-2 border-top border-info">
            <button type="submit" class="btn btn-success btn-block">
              <svg class="icon me-2">
                <use xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg#cil-filter') }}"></use>
              </svg>
              Apply Filters
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
  <div class="col col-lg-8">
    <div class="card">
      <div class="card-header">
        <div class="h5 card-title">Activity Log</div><span class="small ms-2">User activity log</span>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-hover table-bordered">
            <thead>
              <th>Event</th>
              <th>Description</th>
              <th>Subject</th>
              <th>User</th>
              <th>Date</th>
              <th>Action</th>
            </thead>
            <tbody>
              @forelse($data as $item)
              <tr>
                <td>
                  <span class="badge badge-md bg-{{$item->color}}">{{$item->eventType}}</span>
                </td>
                <td>{{$item->description}}</td>
                <td>{{$item->subject_type}} <span class="text-muted text-secondary">#{{$item->subject_id}}</span></td>
                <td>
                  @if($item->causer)
                  <div class="row">
                    <div class="col-12 col-sm-6">{{$item->causer ? $item->causer->name : "Unknown"}}</div>
                    <div class="col-12 col-sm-6 float-sm-right">
                      <span class="text-muted">
                    {{$item->causer && $item->causer->email ? $item->causer->email : ""}}
                      </span>
                    </div>
                  </div>
                  @else
                  <span>No user</span>
                  @endif
                </td>
                <td>
                  <strong>{{$item->created_at->format("d/m/Y")}}</strong>
                  <small class="text-muted">{{$item->created_at->format("H:i:s")}}</small>
                </td>
                <td></td>
              </tr>
              @empty
              <tr>
                <td colspan="6" class="text-center"><span class="text-muted">No record found.</span></span>
              </tr>
              @endforelse
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

@section("scripts")
<script>
  window.addEventListener("DOMContentLoaded", function() {
    document.querySelectorAll('.btn-check').forEach(
      radio => radio.addEventListener("click", function(e) {
        if(e.currentTarget.value === "custom") {
          document.getElementById("date-range").classList.remove("d-none");
        } else {
          document.getElementById("date-range").classList.add("d-none");
          document.getElementById("start_date").value = "";
          document.getElementById("end_date").value = "";
        }
      })
    );
  });
</script>
@endsection