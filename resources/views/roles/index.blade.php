@extends('layouts.app')

@section('page_title')
    Roles
@endsection

@php
    $bulkUpdateUrl = route('roles.bulkUpdate');
    $bulkDestroyUrl = route('roles.bulkDestroy');
    $filterResetUrl = route('roles.index');
    $deleteRecordUrl = route('roles.destroy', ['role' => '#PH']);
    $addRecordUrl = route('roles.store');
    $editRecordUrl = route('roles.edit', ['role' => '#PH']);
    $updateRecordUrl = route('roles.update', ['role' => '#PH']);
    $viewRecordUrl = route('roles.show', ['role' => '#PH']);
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
                    @can(['CREATE_MENU'])
                        <button class="icon-btn mr-2 btn btn-sm btn-primary" title="Add Record"
                            onclick="onAddRecordButtonClick();">
                            <i class="fas fa-plus"></i>
                        </button>
                    @endcan
                    @can(['IMPORT_MENU'])
                        <button class="icon-btn mr-2 btn btn-sm btn-info" title="Import Records"
                            onclick="onImportRecordsButtonClick();">
                            <i class="fas fa-download"></i>
                        </button>
                    @endcan
                    @can(['EXPORT_MENU'])
                        <button class="icon-btn mr-2 btn btn-sm btn-success" title="Export Records"
                            onclick="onExportRecordsButtonClick();">
                            <i class="fas fa-upload"></i>
                        </button>
                    @endcan
                </div>
                <div>
                    @can(['BULK_UPDATE_MENU'])
                        <button class="icon-btn mr-2 btn btn-sm btn-warning" title="Bulk Change Status"
                            onclick="onBulkChangeStatusClick('{{ $bulkUpdateUrl }}');">
                            <i class="fas fa-recycle"></i>
                        </button>
                    @endcan
                    @can(['BULK_DELETE_MENU'])
                        <button class="icon-btn mr-2 btn btn-sm btn-danger" title="Bulk Delete Records"
                            onclick="onBulkDeleteRecordsClick('{{ $bulkDestroyUrl }}');">
                            <i class="fas fa-trash"></i>
                        </button>
                    @endcan
                </div>
            </div>
        </div>
        <div class="card-body" style="overflow-x: auto;">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>
                            <input type="checkbox" name="selectAllHead" id="selectAllHead">
                        </th>
                        <th>Sr. No.</th>
                        <th>Name</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($roleList as $role)
                        <tr>
                            <td>
                                <input type="checkbox" name="selectOne{{ $role->id }}"
                                    id="selectOne{{ $role->id }}">
                            </td>
                            <td>{{ $roleList->firstItem() + $loop->index }}</td>
                            <td>{{ $role->name }}</td>
                            <td>
                                @if ($role->is_active)
                                    <span class="badge badge-pill badge-success small text-uppercase">Active</span>
                                @else
                                    <span class="badge badge-pill badge-danger small text-uppercase">Inactive</span>
                                @endif
                            </td>
                            <td>
                                @can(['READ_MENU'])
                                    <button class="icon-btn mb-2 mr-0 mb-md-0 mr-md-2 btn btn-sm btn-primary"
                                        title="View Record" onclick="onViewRecordButtonClick({{ $role->id }});">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                @endcan
                                @can(['UPDATE_MENU'])
                                    <button class="icon-btn mb-2 mr-0 mb-md-0 mr-md-2 btn btn-sm btn-info" title="Change Status"
                                        onclick="sendChangeStatusRequest('{{ $bulkUpdateUrl }}', {{ $role->id }});">
                                        <i class="fas fa-recycle"></i>
                                    </button>
                                @endcan
                                @can(['UPDATE_MENU'])
                                    <button class="icon-btn mb-2 mr-0 mb-md-0 mr-md-2 btn btn-sm btn-warning"
                                        title="Update Record" onclick="onUpdateRecordButtonClick({{ $role->id }});">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                @endcan
                                @can(['DELETE_MENU'])
                                    <button class="icon-btn mb-2 mr-0 mb-md-0 mr-md-2 btn btn-sm btn-danger"
                                        title="Delete Record"
                                        onclick="onDeleteRecordClick('{{ $deleteRecordUrl }}', {{ $role->id }});">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                @endcan
                            </td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <th>
                            <input type="checkbox" name="selectAllFoot" id="selectAllFoot">
                        </th>
                        <th>Sr. No.</th>
                        <th>Name</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </tfoot>
            </table>
        </div>
        <div class="card-footerr">
            <div class="d-flex justify-content-between align-items-center p-4 flex-column flex-md-row">
                <div class="mb-2 mb-md-0">
                    Showing {{ $roleList->firstItem() }} to {{ $roleList->lastItem() }} of
                    {{ $roleList->total() }}
                    entries
                </div>
                <div class="mb-2 mb-md-0">
                    {{ $roleList->onEachSide(1)->links('pagination::bootstrap-4') }}
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
        // ADD RECORD
        function onAddRecordModalResetClick(clearModalAlerts) {
            let addRecordModalName = document.querySelector("#addRecordModalName");
            let addRecordModalPermissions = document.querySelectorAll("[id*='addRecordModalPermission']");

            if (clearModalAlerts) {
                hideModalAlert('addRecordModal', 'success');
                hideModalAlert('addRecordModal', 'danger');
            }
            addRecordModalName.value = "";
            addRecordModalPermissions.forEach(aRMP => aRMP.checked = false);
        }

        function onAddRecordButtonClick() {
            onAddRecordModalResetClick(true);
            $('#addRecordModal').modal('show');
        }

        async function onAddRecordModalSaveClick() {
            hideModalAlert('addRecordModal', 'success');
            hideModalAlert('addRecordModal', 'danger');
            let csrfToken = document.querySelector(
                "meta[name='csrf-token']"
            ).content;

            let addRecordModalName = document.querySelector("#addRecordModalName");
            let addRecordModalPermissions = document.querySelectorAll("[id*='addRecordModalPermission']");
            let permissionsToAdd = [];
            addRecordModalPermissions.forEach(aRMP => {
                if (aRMP.checked) {
                    permissionsToAdd.push(
                        aRMP.name.replace("addRecordModalPermission", ""),
                    );
                }
            });

            let requestUrl = "{{ $addRecordUrl }}";
            let requestData = {
                name: addRecordModalName.value,
                permissions: permissionsToAdd,
            };

            try {
                let response = await axios.post(requestUrl, requestData, {
                    headers: {
                        "X-Requested-With": "XMLHttpRequest",
                        "Content-Type": "multipart/form-data",
                        Accept: "application/json",
                        "X-CSRF-TOKEN": csrfToken,
                    },
                });
                showModalAlert('addRecordModal', 'success', response.data.message);
                onAddRecordModalResetClick(false);
                setTimeout(() => {
                    window.location.reload();
                }, 2000);
            } catch (error) {
                switch (error.response.status) {
                    case 422:
                        let errorMessages = Object.values(error.response.data.errors).flat();
                        showModalAlert('addRecordModal', 'danger', errorMessages.join("<br/>"));
                        break;
                    default:
                        showModalAlert('addRecordModal', 'danger', "Something went wrong, please try again later!");
                        break;
                }

            }
        }

        // UPDATE RECORD
        function onUpdateRecordModalResetClick(clearModalAlerts) {
            let updateRecordModalId = document.querySelector("#updateRecordModalId");
            let updateRecordModalName = document.querySelector("#updateRecordModalName");
            let updateRecordModalPermissions = document.querySelectorAll("[id*='updateRecordModalPermission']");

            if (clearModalAlerts) {
                hideModalAlert('updateRecordModal', 'success');
                hideModalAlert('updateRecordModal', 'danger');
            }
            updateRecordModalId.value = "";
            updateRecordModalName.value = "";
            updateRecordModalPermissions.forEach(uRMP => uRMP.checked = false);
        }

        async function onUpdateRecordButtonClick(selectedItem) {
            onUpdateRecordModalResetClick(true);
            let updateRecordModalId = document.querySelector("#updateRecordModalId");
            updateRecordModalId.value = selectedItem;
            await getDataForUpdateRecordModal(selectedItem);
            $('#updateRecordModal').modal('show');
        }

        async function getDataForUpdateRecordModal(selectedItem) {
            let requestUrl = "{{ $editRecordUrl }}";
            requestUrl = requestUrl.replace("#PH", selectedItem);
            try {
                let response = await axios.get(requestUrl);
                let updateRecordModalName = document.querySelector("#updateRecordModalName");
                let updateRecordModalPermissions = document.querySelectorAll("[id*='updateRecordModalPermission']");

                updateRecordModalName.value = response.data.data.role.name;
                updateRecordModalPermissions.forEach(uRMP => {
                    let permissionName = uRMP.id.replace("updateRecordModalPermission", "");
                    if (response.data.data.permissions.includes(permissionName)) {
                        uRMP.checked = true;
                    }
                });
            } catch (error) {
                console.log(error);
                alert("Something went wrong, please try again later!");
            }
        }

        async function onUpdateRecordModalSaveClick() {
            hideModalAlert('updateRecordModal', 'success');
            hideModalAlert('updateRecordModal', 'danger');
            let csrfToken = document.querySelector(
                "meta[name='csrf-token']"
            ).content;

            let updateRecordModalId = document.querySelector("#updateRecordModalId");
            let updateRecordModalName = document.querySelector("#updateRecordModalName");
            let updateRecordModalPermissions = document.querySelectorAll("[id*='updateRecordModalPermission']");
            let permissionsToUpdate = [];
            updateRecordModalPermissions.forEach(uRMP => {
                if (uRMP.checked) {
                    permissionsToUpdate.push(
                        uRMP.name.replace("updateRecordModalPermission", ""),
                    );
                }
            });

            let requestUrl = "{{ $updateRecordUrl }}";
            requestUrl = requestUrl.replace("#PH", updateRecordModalId.value);
            let requestData = {
                name: updateRecordModalName.value,
                permissions: permissionsToUpdate,
                _method: "PUT",
            };
            try {
                let response = await axios.post(requestUrl, requestData, {
                    headers: {
                        "X-Requested-With": "XMLHttpRequest",
                        "Content-Type": "multipart/form-data",
                        Accept: "application/json",
                        "X-CSRF-TOKEN": csrfToken,
                    },
                });
                showModalAlert('updateRecordModal', 'success', response.data.message);
                onUpdateRecordModalResetClick(false);
                setTimeout(() => {
                    window.location.reload();
                }, 2000);
            } catch (error) {
                switch (error.response.status) {
                    case 422:
                        let errorMessages = Object.values(error.response.data.errors).flat();
                        showModalAlert('updateRecordModal', 'danger', errorMessages.join("<br/>"));
                        break;
                    default:
                        showModalAlert('updateRecordModal', 'danger', "Something went wrong, please try again later!");
                        break;
                }

            }
        }

        // VIEW RECORD
        function onViewRecordModalResetClick(clearModalAlerts) {
            let viewRecordModalId = document.querySelector("#viewRecordModalId");
            let viewRecordModalName = document.querySelector("#viewRecordModalName");
            let viewRecordModalPermissions = document.querySelectorAll("[id*='viewRecordModalPermission']");

            if (clearModalAlerts) {
                hideModalAlert('viewRecordModal', 'success');
                hideModalAlert('viewRecordModal', 'danger');
            }
            viewRecordModalId.value = "";
            viewRecordModalName.value = "";
            viewRecordModalPermissions.forEach(vRMP => vRMP.checked = false);
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
                let viewRecordModalName = document.querySelector("#viewRecordModalName");
                let viewRecordModalPermissions = document.querySelectorAll("[id*='viewRecordModalPermission']");

                viewRecordModalName.value = response.data.data.role.name;
                viewRecordModalPermissions.forEach(vRMP => {
                    let permissionName = vRMP.id.replace("viewRecordModalPermission", "");
                    if (response.data.data.permissions.includes(permissionName)) {
                        vRMP.checked = true;
                    }
                });
            } catch (error) {
                console.log(error);
                alert("Something went wrong, please try again later!");
            }
        }

        // IMPORT RECORDS
        function onImportRecordsButtonClick() {
            alert('This feature is not implemented yet!');
        }

        // EXPORT RECORDS
        function onExportRecordsButtonClick() {
            alert('This feature is not implemented yet!');
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
                                        <option value="name" @if (old('sortBy') === 'name') selected @endif>Name
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
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="status">Status:</label>
                                    <select class="custom-select" id="status" name="status"
                                        value="{{ old('status') }}">
                                        <option value="" @if (old('status') === '') selected @endif></option>
                                        <option value="active" @if (old('status') === 'active') selected @endif>Active
                                        </option>
                                        <option value="inactive" @if (old('status') === 'inactive') selected @endif>
                                            Inactive</option>
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

    <!-- ADD RECORD MODAL -->
    <div class="modal fade" id="addRecordModal" tabindex="-1" aria-labelledby="addRecordModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addRecordModalLabel">Add Record</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
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
                            <x-form-text-input id="addRecordModalName" label="Name" required />
                        </div>
                        <div class="col-md-12">
                            @if ($crudPermissions->count() > 0)
                                <div style="overflow-x: auto;">
                                    <table class="table table-striped table-hover">
                                        <thead>
                                            <tr>
                                                <th>Model</th>
                                                <th>CREATE</th>
                                                <th>READ</th>
                                                <th>UPDATE</th>
                                                <th>DELETE</th>
                                                <th>IMPORT</th>
                                                <th>EXPORT</th>
                                                <th>BULK UPDATE</th>
                                                <th>BULK DELETE</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($crudPermissions as $key => $crudPermission)
                                                <tr>
                                                    <td>{{ $key }}</td>
                                                    @foreach ($crudPermission as $cp)
                                                        <td>
                                                            <div class="form-group">
                                                                <div class="custom-control custom-switch">
                                                                    <input type="checkbox" class="custom-control-input"
                                                                        id="addRecordModalPermission{{ $cp->name }}"
                                                                        name="addRecordModalPermission{{ $cp->name }}"
                                                                        aria-label="addRecordModalPermission{{ $cp->name }}">
                                                                    <label class="custom-control-label"
                                                                        for="addRecordModalPermission{{ $cp->name }}"
                                                                        aria-label="addRecordModalPermission{{ $cp->name }}"></label>
                                                                </div>
                                                            </div>
                                                        </td>
                                                    @endforeach
                                                </tr>
                                            @endforeach
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th>Model</th>
                                                <th>CREATE</th>
                                                <th>READ</th>
                                                <th>UPDATE</th>
                                                <th>DELETE</th>
                                                <th>IMPORT</th>
                                                <th>EXPORT</th>
                                                <th>BULK UPDATE</th>
                                                <th>BULK DELETE</th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            @endif
                        </div>
                        <div class="col-md-12">
                            @if ($nonCrudPermissions->count() > 0)
                                <div style="overflow-x: auto;">
                                    <table class="table table-striped table-hover">
                                        <thead>
                                            <tr>
                                                <th>Model</th>
                                                <th>Permission</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($nonCrudPermissions as $key => $nonCrudPermission)
                                                <tr>
                                                    <td>{{ $key }}</td>
                                                    @foreach ($nonCrudPermission as $cp)
                                                        <td>
                                                            <div class="form-group">
                                                                <div class="custom-control custom-switch">
                                                                    <input type="checkbox" class="custom-control-input"
                                                                        id="addRecordModalPermission{{ $cp->name }}"
                                                                        name="addRecordModalPermission{{ $cp->name }}"
                                                                        aria-label="addRecordModalPermission{{ $cp->name }}">
                                                                    <label class="custom-control-label"
                                                                        for="addRecordModalPermission{{ $cp->name }}"
                                                                        aria-label="addRecordModalPermission{{ $cp->name }}"></label>
                                                                </div>
                                                            </div>
                                                        </td>
                                                    @endforeach
                                                </tr>
                                            @endforeach
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th>Model</th>
                                                <th>Permission</th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" data-dismiss="modal" class="btn btn-secondary"
                        onclick="onAddRecordModalResetClick(true);">Close</button>
                    <button type="button" class="btn btn-primary" onclick="onAddRecordModalSaveClick();">Save</button>
                </div>
            </div>
        </div>
    </div>

    <!-- VIEW RECORD MODAL -->
    <div class="modal fade" id="viewRecordModal" tabindex="-1" aria-labelledby="viewRecordModalLabel"
        aria-hidden="true">
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
                            <x-form-text-input id="viewRecordModalName" label="Name" required disabled />
                        </div>
                        <div class="col-md-12">
                            @if ($crudPermissions->count() > 0)
                                <div style="overflow-x: auto;">
                                    <table class="table table-striped table-hover">
                                        <thead>
                                            <tr>
                                                <th>Model</th>
                                                <th>CREATE</th>
                                                <th>READ</th>
                                                <th>UPDATE</th>
                                                <th>DELETE</th>
                                                <th>IMPORT</th>
                                                <th>EXPORT</th>
                                                <th>BULK UPDATE</th>
                                                <th>BULK DELETE</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($crudPermissions as $key => $crudPermission)
                                                <tr>
                                                    <td>{{ $key }}</td>
                                                    @foreach ($crudPermission as $cp)
                                                        <td>
                                                            <div class="form-group">
                                                                <div class="custom-control custom-switch">
                                                                    <input type="checkbox" class="custom-control-input"
                                                                        id="viewRecordModalPermission{{ $cp->name }}"
                                                                        name="viewRecordModalPermission{{ $cp->name }}"
                                                                        aria-label="viewRecordModalPermission{{ $cp->name }}"
                                                                        disabled>
                                                                    <label class="custom-control-label"
                                                                        for="viewRecordModalPermission{{ $cp->name }}"
                                                                        aria-label="viewRecordModalPermission{{ $cp->name }}"></label>
                                                                </div>
                                                            </div>
                                                        </td>
                                                    @endforeach
                                                </tr>
                                            @endforeach
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th>Model</th>
                                                <th>CREATE</th>
                                                <th>READ</th>
                                                <th>UPDATE</th>
                                                <th>DELETE</th>
                                                <th>IMPORT</th>
                                                <th>EXPORT</th>
                                                <th>BULK UPDATE</th>
                                                <th>BULK DELETE</th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            @endif
                        </div>
                        <div class="col-md-12">
                            @if ($nonCrudPermissions->count() > 0)
                                <div style="overflow-x: auto;">
                                    <table class="table table-striped table-hover">
                                        <thead>
                                            <tr>
                                                <th>Model</th>
                                                <th>Permission</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($nonCrudPermissions as $key => $nonCrudPermission)
                                                <tr>
                                                    <td>{{ $key }}</td>
                                                    @foreach ($nonCrudPermission as $cp)
                                                        <td>
                                                            <div class="form-group">
                                                                <div class="custom-control custom-switch">
                                                                    <input type="checkbox" class="custom-control-input"
                                                                        id="viewRecordModalPermission{{ $cp->name }}"
                                                                        name="viewRecordModalPermission{{ $cp->name }}"
                                                                        aria-label="viewRecordModalPermission{{ $cp->name }}"
                                                                        disabled>
                                                                    <label class="custom-control-label"
                                                                        for="viewRecordModalPermission{{ $cp->name }}"
                                                                        aria-label="viewRecordModalPermission{{ $cp->name }}"></label>
                                                                </div>
                                                            </div>
                                                        </td>
                                                    @endforeach
                                                </tr>
                                            @endforeach
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th>Model</th>
                                                <th>Permission</th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            @endif
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

    <!-- UPDATE RECORD MODAL -->
    <div class="modal fade" id="updateRecordModal" tabindex="-1" aria-labelledby="updateRecordModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="updateRecordModalLabel">Update Record</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="updateRecordModalId" id="updateRecordModalId">
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
                            <x-form-text-input id="updateRecordModalName" label="Name" required />
                        </div>
                        <div class="col-md-12">
                            @if ($crudPermissions->count() > 0)
                                <div style="overflow-x: auto;">
                                    <table class="table table-striped table-hover">
                                        <thead>
                                            <tr>
                                                <th>Model</th>
                                                <th>CREATE</th>
                                                <th>READ</th>
                                                <th>UPDATE</th>
                                                <th>DELETE</th>
                                                <th>IMPORT</th>
                                                <th>EXPORT</th>
                                                <th>BULK UPDATE</th>
                                                <th>BULK DELETE</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($crudPermissions as $key => $crudPermission)
                                                <tr>
                                                    <td>{{ $key }}</td>
                                                    @foreach ($crudPermission as $cp)
                                                        <td>
                                                            <div class="form-group">
                                                                <div class="custom-control custom-switch">
                                                                    <input type="checkbox" class="custom-control-input"
                                                                        id="updateRecordModalPermission{{ $cp->name }}"
                                                                        name="updateRecordModalPermission{{ $cp->name }}"
                                                                        aria-label="updateRecordModalPermission{{ $cp->name }}">
                                                                    <label class="custom-control-label"
                                                                        for="updateRecordModalPermission{{ $cp->name }}"
                                                                        aria-label="updateRecordModalPermission{{ $cp->name }}"></label>
                                                                </div>
                                                            </div>
                                                        </td>
                                                    @endforeach
                                                </tr>
                                            @endforeach
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th>Model</th>
                                                <th>CREATE</th>
                                                <th>READ</th>
                                                <th>UPDATE</th>
                                                <th>DELETE</th>
                                                <th>IMPORT</th>
                                                <th>EXPORT</th>
                                                <th>BULK UPDATE</th>
                                                <th>BULK DELETE</th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            @endif
                        </div>
                        <div class="col-md-12">
                            @if ($nonCrudPermissions->count() > 0)
                                <div style="overflow-x: auto;">
                                    <table class="table table-striped table-hover">
                                        <thead>
                                            <tr>
                                                <th>Model</th>
                                                <th>Permission</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($nonCrudPermissions as $key => $nonCrudPermission)
                                                <tr>
                                                    <td>{{ $key }}</td>
                                                    @foreach ($nonCrudPermission as $cp)
                                                        <td>
                                                            <div class="form-group">
                                                                <div class="custom-control custom-switch">
                                                                    <input type="checkbox" class="custom-control-input"
                                                                        id="updateRecordModalPermission{{ $cp->name }}"
                                                                        name="updateRecordModalPermission{{ $cp->name }}"
                                                                        aria-label="updateRecordModalPermission{{ $cp->name }}">
                                                                    <label class="custom-control-label"
                                                                        for="updateRecordModalPermission{{ $cp->name }}"
                                                                        aria-label="updateRecordModalPermission{{ $cp->name }}"></label>
                                                                </div>
                                                            </div>
                                                        </td>
                                                    @endforeach
                                                </tr>
                                            @endforeach
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th>Model</th>
                                                <th>Permission</th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" data-dismiss="modal" class="btn btn-secondary"
                        onclick="onUpdateRecordModalResetClick(true);">Close</button>
                    <button type="button" class="btn btn-primary"
                        onclick="onUpdateRecordModalSaveClick();">Save</button>
                </div>
            </div>
        </div>
    </div>
@endsection
