@extends('layouts.app')

@section('page_title')
    Auth Logs
@endsection

@php
    $filterResetUrl = route('auth-logs.index');
    $viewRecordUrl = route('auth-logs.show', ['auth_log' => '#PH']);
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
                        <th>Username</th>
                        <th>Email</th>
                        <th>Mobile Number</th>
                        <th>Action</th>
                        <th>Created At</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($authLogList as $authLog)
                        <tr>
                            <td>{{ $authLogList->firstItem() + $loop->index }}</td>
                            <td>{{ $authLog->username ? $authLog->username : '-' }}</td>
                            <td>{{ $authLog->email ? $authLog->email : '-' }}</td>
                            <td>{{ $authLog->mobile_number ? $authLog->mobile_number : '-' }}</td>
                            <td>{{ $authLog->action }}</td>
                            <td>
                                {{ $authLog->created_at->diffForHumans() }}
                            </td>
                            <td>
                                @can(['READ_MENU'])
                                    <button class="icon-btn mb-2 mr-0 mb-md-0 mr-md-2 btn btn-sm btn-primary"
                                        title="View Record" onclick="onViewRecordButtonClick({{ $authLog->id }});">
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
                        <th>Username</th>
                        <th>Email</th>
                        <th>Mobile Number</th>
                        <th>Action</th>
                        <th>Created At</th>
                    </tr>
                </tfoot>
            </table>
        </div>
        <div class="card-footerr">
            <div class="d-flex justify-content-between align-items-center p-4 flex-column flex-md-row">
                <div class="mb-2 mb-md-0">
                    Showing {{ $authLogList->firstItem() }} to {{ $authLogList->lastItem() }} of
                    {{ $authLogList->total() }}
                    entries
                </div>
                <div class="mb-2 mb-md-0">
                    {{ $authLogList->onEachSide(1)->links('pagination::bootstrap-4') }}
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
            let viewRecordModalUserAgent = document.querySelector("#viewRecordModalUserAgent");
            let viewRecordModalEmail = document.querySelector("#viewRecordModalEmail");
            let viewRecordModalUsername = document.querySelector("#viewRecordModalUsername");
            let viewRecordModalMobileNumber = document.querySelector("#viewRecordModalMobileNumber");
            let viewRecordModalAction = document.querySelector("#viewRecordModalAction");

            if (clearModalAlerts) {
                hideModalAlert('viewRecordModal', 'success');
                hideModalAlert('viewRecordModal', 'danger');
            }
            viewRecordModalId.value = "";
            viewRecordModalIpAddress.value = "";
            viewRecordModalUserAgent.value = "";
            viewRecordModalEmail.value = "";
            viewRecordModalUsername.value = "";
            viewRecordModalMobileNumber.value = "";
            viewRecordModalAction.value = "";
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
                let viewRecordModalUserAgent = document.querySelector("#viewRecordModalUserAgent");
                let viewRecordModalEmail = document.querySelector("#viewRecordModalEmail");
                let viewRecordModalUsername = document.querySelector("#viewRecordModalUsername");
                let viewRecordModalMobileNumber = document.querySelector("#viewRecordModalMobileNumber");
                let viewRecordModalAction = document.querySelector("#viewRecordModalAction");

                viewRecordModalIpAddress.value = response.data.data.authLog.ip_address;
                viewRecordModalUserAgent.value = response.data.data.authLog.user_agent;
                viewRecordModalEmail.value = response.data.data.authLog.email ? response.data.data.authLog.email :
                    "-";
                viewRecordModalUsername.value = response.data.data.authLog.username ? response.data.data.authLog
                    .username : "-";
                viewRecordModalMobileNumber.value = response.data.data.authLog.mobile_number ? response.data.data
                    .authLog.mobile_number : "-";
                viewRecordModalAction.value = response.data.data.authLog.action;
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
                                        <option value="user_agent" @if (old('sortBy') === 'user_agent') selected @endif>
                                            User Agent
                                        </option>
                                        <option value="username" @if (old('sortBy') === 'username') selected @endif>
                                            Username
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
                            <x-form-text-input id="viewRecordModalUserAgent" label="User Agent" disabled />
                        </div>
                        <div class="col-md-6">
                            <x-form-text-input id="viewRecordModalEmail" label="Email" required disabled />
                        </div>
                        <div class="col-md-6">
                            <x-form-text-input id="viewRecordModalUsername" label="Username" disabled />
                        </div>
                        <div class="col-md-6">
                            <x-form-text-input id="viewRecordModalMobileNumber" label="Mobile Number" required disabled />
                        </div>
                        <div class="col-md-6">
                            <x-form-text-input id="viewRecordModalAction" label="Action" disabled />
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
