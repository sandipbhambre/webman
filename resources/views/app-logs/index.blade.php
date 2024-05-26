@extends('layouts.app')

@section('page_title')
    App Logs
@endsection

@php
    $filterResetUrl = route('app-logs.index');
    $viewRecordUrl = route('app-logs.show', ['app_log' => '#PH']);
@endphp

@section('page_content')
    <div class="card card-outline card-primary" style="overflow-x: hidden;">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <button class="icon-btn mr-2 btn btn-sm btn-dark" title="Filter Records" data-toggle="modal"
                        data-target="#filterRecordsModal">
                        <i class="fas fa-filter"></i>
                    </button>
                </div>
            </div>
        </div>
        <div class="card-body" style="overflow-x: auto;">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>Sr. No.</th>
                        <th>IP Address</th>
                        <th>Username</th>
                        <th>Model</th>
                        <th>Operation</th>
                        <th>Created At</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($appLogList as $appLog)
                        <tr>
                            <td>{{ $appLogList->firstItem() + $loop->index }}</td>
                            <td>{{ $appLog->ip_address }}</td>
                            <td>{{ $appLog->username ? $appLog->username : '-' }}</td>
                            <td>{{ $appLog->model }}</td>
                            <td>{{ $appLog->operation }}</td>
                            <td>
                                {{ $appLog->created_at->diffForHumans() }}
                            </td>
                            <td>
                                @can(['READ_MENU'])
                                    <button class="icon-btn mb-2 mr-0 mb-md-0 mr-md-2 btn btn-sm btn-primary"
                                        title="View Record" onclick="onViewRecordButtonClick({{ $appLog->id }});">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                @endcan
                            </td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <th>Sr. No.</th>
                        <th>IP Address</th>
                        <th>Username</th>
                        <th>Model</th>
                        <th>Operation</th>
                        <th>Created At</th>
                    </tr>
                </tfoot>
            </table>
        </div>
        <div class="card-footerr">
            <div class="d-flex justify-content-between align-items-center p-4 flex-column flex-md-row">
                <div class="mb-2 mb-md-0">
                    Showing {{ $appLogList->firstItem() }} to {{ $appLogList->lastItem() }} of
                    {{ $appLogList->total() }}
                    entries
                </div>
                <div class="mb-2 mb-md-0">
                    {{ $appLogList->onEachSide(1)->links('pagination::bootstrap-4') }}
                </div>
            </div>
        </div>
    </div>
@endsection

@section('page_scripts')
    <!-- Input Helper -->
    <script src="{{ asset('assets/scripts/input_helper.js') }}"></script>
    <!-- Table Helper -->
    <script src="{{ asset('assets/scripts/table-helper.js') }}"></script>

    <script>
        // VIEW RECORD
        function onViewRecordModalResetClick(clearModalAlerts) {
            let viewRecordModalId = document.querySelector("#viewRecordModalId");
            let viewRecordModalIpAddress = document.querySelector("#viewRecordModalIpAddress");
            let viewRecordModalUsername = document.querySelector("#viewRecordModalUsername");
            let viewRecordModalModel = document.querySelector("#viewRecordModalModel");
            let viewRecordModalModelId = document.querySelector("#viewRecordModalModelId");
            let viewRecordModalOperation = document.querySelector("#viewRecordModalOperation");

            if (clearModalAlerts) {
                hideModalAlert('viewRecordModal', 'success');
                hideModalAlert('viewRecordModal', 'danger');
            }
            viewRecordModalId.value = "";
            viewRecordModalIpAddress.value = "";
            viewRecordModalUsername.value = "";
            viewRecordModalModel.value = "";
            viewRecordModalModelId.value = "";
            viewRecordModalOperation.value = "";
        }

        async function onViewRecordButtonClick(selectedItem) {
            onViewRecordModalResetClick(true);
            let viewRecordModalId = document.querySelector("#viewRecordModalId");
            viewRecordModalId.value = selectedItem;
            await getDataForViewRecordModal(selectedItem);
            $('#viewRecordModal').modal('show');
        }

        async function getDataForViewRecordModal(selectedItem) {
            let requestUrl = "{{ $viewRecordUrl }}";
            requestUrl = requestUrl.replace("#PH", selectedItem);
            try {
                let response = await axios.get(requestUrl);
                let viewRecordModalIpAddress = document.querySelector("#viewRecordModalIpAddress");
                let viewRecordModalUsername = document.querySelector("#viewRecordModalUsername");
                let viewRecordModalModel = document.querySelector("#viewRecordModalModel");
                let viewRecordModalModelId = document.querySelector("#viewRecordModalModelId");
                let viewRecordModalOperation = document.querySelector("#viewRecordModalOperation");

                viewRecordModalIpAddress.value = response.data.data.appLog.ip_address;
                viewRecordModalUsername.value = response.data.data.appLog.username ? response.data.data.appLog
                    .username : "-";
                viewRecordModalModel.value = response.data.data.appLog.model;
                viewRecordModalModelId.value = response.data.data.appLog.model_id;
                viewRecordModalOperation.value = response.data.data.appLog.operation;
            } catch (error) {
                console.log(error);
                alert("Something went wrong, please try again later!");
            }
        }
    </script>
@endsection

@section('page_styles')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('page_modals')
    <!-- FILTER RECORDS MODAL -->
    <form method="GET" action="{{ $filterResetUrl }}" id="filterRecordsModalForm">
        <div class="modal fade" id="filterRecordsModal" tabindex="-1" aria-labelledby="filterRecordsModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="filterRecordsModalLabel">Filter Records</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="search">Search:</label>
                                    <input type="text" class="form-control" id="search" name="search"
                                        value="{{ old('search') }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="sortBy">Sort By:</label>
                                    <select class="custom-select" id="sortBy" name="sortBy">
                                        <option value="" @if (old('sortBy') === '') selected @endif></option>
                                        <option value="ip_address" @if (old('sortBy') === 'ip_address') selected @endif>IP
                                            Address
                                        </option>
                                        <option value="username" @if (old('sortBy') === 'username') selected @endif>
                                            Username
                                        </option>
                                        <option value="operation" @if (old('sortBy') === 'operation') selected @endif>
                                            Operation
                                        </option>
                                        <option value="model" @if (old('sortBy') === 'model') selected @endif>
                                            Model
                                        </option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="numberOfRecords">Number of Records:</label>
                                    <select class="custom-select" id="numberOfRecords" name="numberOfRecords">
                                        <option value="" @if (old('numberOfRecords') === '') selected @endif></option>
                                        <option value="10" @if (old('numberOfRecords') === '10') selected @endif>10
                                        </option>
                                        <option value="25" @if (old('numberOfRecords') === '25') selected @endif>25
                                        </option>
                                        <option value="50" @if (old('numberOfRecords') === '50') selected @endif>50
                                        </option>
                                        <option value="100" @if (old('numberOfRecords') === '100') selected @endif>100
                                        </option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" onclick="onFilterRecordsModalResetClick('{{ $filterResetUrl }}');"
                            class="btn btn-secondary">Reset</button>
                        <button type="submit" class="btn btn-primary">Apply</button>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <!-- VIEW RECORD MODAL -->
    <div class="modal fade" id="viewRecordModal" tabindex="-1" aria-labelledby="viewRecordModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="viewRecordModalLabel">View Record</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="viewRecordModalId" id="viewRecordModalId">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="alert alert-success d-none">
                                <h5><i class="icon fas fa-check"></i> Alert!</h5>
                                <div></div>
                            </div>
                            <div class="alert alert-danger d-none">
                                <h5><i class="icon fas fa-ban"></i> Alert!</h5>
                                <div></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <x-form-text-input id="viewRecordModalIpAddress" label="IP Address" required disabled />
                        </div>
                        <div class="col-md-6">
                            <x-form-text-input id="viewRecordModalUsername" label="Username" disabled />
                        </div>
                        <div class="col-md-6">
                            <x-form-text-input id="viewRecordModalModel" label="Model" required disabled />
                        </div>
                        <div class="col-md-6">
                            <x-form-text-input id="viewRecordModalModelId" label="Model ID" disabled />
                        </div>
                        <div class="col-md-6">
                            <x-form-text-input id="viewRecordModalOperation" label="Operation" required disabled />
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" data-dismiss="modal" class="btn btn-secondary"
                        onclick="onViewRecordModalResetClick(true);">Close</button>
                </div>
            </div>
        </div>
    </div>
@endsection
