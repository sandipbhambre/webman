@extends('layouts.app')

@section('page_title')
    Menus
@endsection

@php
    $bulkUpdateUrl = route('menus.bulkUpdate');
    $bulkDestroyUrl = route('menus.bulkDestroy');
    $filterResetUrl = route('menus.index');
    $deleteRecordUrl = route('menus.destroy', ['menu' => '#PH']);
    $addRecordUrl = route('menus.store');
    $editRecordUrl = route('menus.edit', ['menu' => '#PH']);
    $updateRecordUrl = route('menus.update', ['menu' => '#PH']);
    $viewRecordUrl = route('menus.show', ['menu' => '#PH']);
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
                        <th>Title</th>
                        <th>Sub Title</th>
                        <th>Icon</th>
                        <th>Sub Icon</th>
                        <th>Order</th>
                        <th>Sub Order</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($menuList as $menu)
                        <tr>
                            <td>
                                <input type="checkbox" name="selectOne{{ $menu->id }}"
                                    id="selectOne{{ $menu->id }}">
                            </td>
                            <td>{{ $menuList->firstItem() + $loop->index }}</td>
                            <td>{{ $menu->title }}</td>
                            <td>{{ $menu->sub_title ? $menu->sub_title : '-' }}</td>
                            <td>{{ $menu->icon }}</td>
                            <td>{{ $menu->sub_icon ? $menu->sub_icon : '-' }}</td>
                            <td>{{ $menu->order }}</td>
                            <td>{{ $menu->sub_order ? $menu->sub_order : '-' }}</td>
                            <td>
                                @if ($menu->is_active)
                                    <span class="badge badge-pill badge-success small text-uppercase">Active</span>
                                @else
                                    <span class="badge badge-pill badge-danger small text-uppercase">Inactive</span>
                                @endif
                            </td>
                            <td>
                                @can(['READ_MENU'])
                                    <button class="icon-btn mb-2 mr-0 mb-md-0 mr-md-2 btn btn-sm btn-primary"
                                        title="View Record" onclick="onViewRecordButtonClick({{ $menu->id }});">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                @endcan
                                @can(['UPDATE_MENU'])
                                    <button class="icon-btn mb-2 mr-0 mb-md-0 mr-md-2 btn btn-sm btn-info" title="Change Status"
                                        onclick="sendChangeStatusRequest('{{ $bulkUpdateUrl }}', {{ $menu->id }});">
                                        <i class="fas fa-recycle"></i>
                                    </button>
                                @endcan
                                @can(['UPDATE_MENU'])
                                    <button class="icon-btn mb-2 mr-0 mb-md-0 mr-md-2 btn btn-sm btn-warning"
                                        title="Update Record" onclick="onUpdateRecordButtonClick({{ $menu->id }});">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                @endcan
                                @can(['DELETE_MENU'])
                                    <button class="icon-btn mb-2 mr-0 mb-md-0 mr-md-2 btn btn-sm btn-danger"
                                        title="Delete Record"
                                        onclick="onDeleteRecordClick('{{ $deleteRecordUrl }}', {{ $menu->id }});">
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
                        <th>Title</th>
                        <th>Sub Title</th>
                        <th>Icon</th>
                        <th>Sub Icon</th>
                        <th>Order</th>
                        <th>Sub Order</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </tfoot>
            </table>
        </div>
        <div class="card-footerr">
            <div class="d-flex justify-content-between align-items-center p-4 flex-column flex-md-row">
                <div class="mb-2 mb-md-0">
                    Showing {{ $menuList->firstItem() }} to {{ $menuList->lastItem() }} of
                    {{ $menuList->total() }}
                    entries
                </div>
                <div class="mb-2 mb-md-0">
                    {{ $menuList->onEachSide(1)->links('pagination::bootstrap-4') }}
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
            let addRecordModalTitle = document.querySelector("#addRecordModalTitle");
            let addRecordModalSubTitle = document.querySelector("#addRecordModalSubTitle");
            let addRecordModalIcon = document.querySelector("#addRecordModalIcon");
            let addRecordModalSubIcon = document.querySelector("#addRecordModalSubIcon");
            let addRecordModalOrder = document.querySelector("#addRecordModalOrder");
            let addRecordModalSubOrder = document.querySelector("#addRecordModalSubOrder");
            let addRecordModalRoute = document.querySelector("#addRecordModalRoute");
            let addRecordModalPermissions = document.querySelector("#addRecordModalPermissions");

            if (clearModalAlerts) {
                hideModalAlert('addRecordModal', 'success');
                hideModalAlert('addRecordModal', 'danger');
            }
            addRecordModalTitle.value = "";
            addRecordModalSubTitle.value = "";
            addRecordModalIcon.value = "";
            addRecordModalSubIcon.value = "";
            addRecordModalOrder.value = "";
            addRecordModalSubOrder.value = "";
            addRecordModalRoute.value = "";
            addRecordModalPermissions.value = "";
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

            let addRecordModalTitle = document.querySelector("#addRecordModalTitle");
            let addRecordModalSubTitle = document.querySelector("#addRecordModalSubTitle");
            let addRecordModalIcon = document.querySelector("#addRecordModalIcon");
            let addRecordModalSubIcon = document.querySelector("#addRecordModalSubIcon");
            let addRecordModalOrder = document.querySelector("#addRecordModalOrder");
            let addRecordModalSubOrder = document.querySelector("#addRecordModalSubOrder");
            let addRecordModalRoute = document.querySelector("#addRecordModalRoute");
            let addRecordModalPermissions = document.querySelector("#addRecordModalPermissions");

            let requestUrl = "{{ $addRecordUrl }}";
            let requestData = {
                title: addRecordModalTitle.value,
                sub_title: addRecordModalSubTitle.value,
                icon: addRecordModalIcon.value,
                sub_icon: addRecordModalSubIcon.value,
                order: addRecordModalOrder.value,
                sub_order: addRecordModalSubOrder.value,
                route: addRecordModalRoute.value,
                permissions: addRecordModalPermissions.value,
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
            let updateRecordModalTitle = document.querySelector("#updateRecordModalTitle");
            let updateRecordModalSubTitle = document.querySelector("#updateRecordModalSubTitle");
            let updateRecordModalIcon = document.querySelector("#updateRecordModalIcon");
            let updateRecordModalSubIcon = document.querySelector("#updateRecordModalSubIcon");
            let updateRecordModalOrder = document.querySelector("#updateRecordModalOrder");
            let updateRecordModalSubOrder = document.querySelector("#updateRecordModalSubOrder");
            let updateRecordModalRoute = document.querySelector("#updateRecordModalRoute");
            let updateRecordModalPermissions = document.querySelector("#updateRecordModalPermissions");

            if (clearModalAlerts) {
                hideModalAlert('updateRecordModal', 'success');
                hideModalAlert('updateRecordModal', 'danger');
            }
            updateRecordModalId.value = "";
            updateRecordModalTitle.value = "";
            updateRecordModalSubTitle.value = "";
            updateRecordModalIcon.value = "";
            updateRecordModalSubIcon.value = "";
            updateRecordModalOrder.value = "";
            updateRecordModalSubOrder.value = "";
            updateRecordModalRoute.value = "";
            updateRecordModalPermissions.value = "";
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
                let updateRecordModalTitle = document.querySelector("#updateRecordModalTitle");
                let updateRecordModalSubTitle = document.querySelector("#updateRecordModalSubTitle");
                let updateRecordModalIcon = document.querySelector("#updateRecordModalIcon");
                let updateRecordModalSubIcon = document.querySelector("#updateRecordModalSubIcon");
                let updateRecordModalOrder = document.querySelector("#updateRecordModalOrder");
                let updateRecordModalSubOrder = document.querySelector("#updateRecordModalSubOrder");
                let updateRecordModalRoute = document.querySelector("#updateRecordModalRoute");
                let updateRecordModalPermissions = document.querySelector("#updateRecordModalPermissions");

                updateRecordModalTitle.value = response.data.data.permission.title;
                updateRecordModalSubTitle.value = response.data.data.permission.sub_title;
                updateRecordModalIcon.value = response.data.data.permission.icon;
                updateRecordModalSubIcon.value = response.data.data.permission.sub_icon;
                updateRecordModalOrder.value = response.data.data.permission.order;
                updateRecordModalSubOrder.value = response.data.data.permission.sub_order;
                updateRecordModalRoute.value = response.data.data.permission.route;
                updateRecordModalPermissions.value = response.data.data.permission.permissions;
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
            let updateRecordModalTitle = document.querySelector("#updateRecordModalTitle");
            let updateRecordModalSubTitle = document.querySelector("#updateRecordModalSubTitle");
            let updateRecordModalIcon = document.querySelector("#updateRecordModalIcon");
            let updateRecordModalSubIcon = document.querySelector("#updateRecordModalSubIcon");
            let updateRecordModalOrder = document.querySelector("#updateRecordModalOrder");
            let updateRecordModalSubOrder = document.querySelector("#updateRecordModalSubOrder");
            let updateRecordModalRoute = document.querySelector("#updateRecordModalRoute");
            let updateRecordModalPermissions = document.querySelector("#updateRecordModalPermissions");

            let requestUrl = "{{ $updateRecordUrl }}";
            requestUrl = requestUrl.replace("#PH", updateRecordModalId.value);
            let requestData = {
                title: updateRecordModalTitle.value,
                sub_title: updateRecordModalSubTitle.value,
                icon: updateRecordModalIcon.value,
                sub_icon: updateRecordModalSubIcon.value,
                order: updateRecordModalOrder.value,
                sub_order: updateRecordModalSubOrder.value,
                route: updateRecordModalRoute.value,
                permissions: updateRecordModalPermissions.value,
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
            let viewRecordModalTitle = document.querySelector("#viewRecordModalTitle");
            let viewRecordModalSubTitle = document.querySelector("#viewRecordModalSubTitle");
            let viewRecordModalIcon = document.querySelector("#viewRecordModalIcon");
            let viewRecordModalSubIcon = document.querySelector("#viewRecordModalSubIcon");
            let viewRecordModalOrder = document.querySelector("#viewRecordModalOrder");
            let viewRecordModalSubOrder = document.querySelector("#viewRecordModalSubOrder");
            let viewRecordModalRoute = document.querySelector("#viewRecordModalRoute");
            let viewRecordModalPermissions = document.querySelector("#viewRecordModalPermissions");

            if (clearModalAlerts) {
                hideModalAlert('viewRecordModal', 'success');
                hideModalAlert('viewRecordModal', 'danger');
            }
            viewRecordModalId.value = "";
            viewRecordModalTitle.value = "";
            viewRecordModalSubTitle.value = "";
            viewRecordModalIcon.value = "";
            viewRecordModalSubIcon.value = "";
            viewRecordModalOrder.value = "";
            viewRecordModalSubOrder.value = "";
            viewRecordModalRoute.value = "";
            viewRecordModalPermissions.value = "";
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
                let viewRecordModalTitle = document.querySelector("#viewRecordModalTitle");
                let viewRecordModalSubTitle = document.querySelector("#viewRecordModalSubTitle");
                let viewRecordModalIcon = document.querySelector("#viewRecordModalIcon");
                let viewRecordModalSubIcon = document.querySelector("#viewRecordModalSubIcon");
                let viewRecordModalOrder = document.querySelector("#viewRecordModalOrder");
                let viewRecordModalSubOrder = document.querySelector("#viewRecordModalSubOrder");
                let viewRecordModalRoute = document.querySelector("#viewRecordModalRoute");
                let viewRecordModalPermissions = document.querySelector("#viewRecordModalPermissions");

                viewRecordModalTitle.value = response.data.data.menu.title;
                viewRecordModalSubTitle.value = response.data.data.menu.sub_title;
                viewRecordModalIcon.value = response.data.data.menu.icon;
                viewRecordModalSubIcon.value = response.data.data.menu.sub_icon;
                viewRecordModalOrder.value = response.data.data.menu.order;
                viewRecordModalSubOrder.value = response.data.data.menu.sub_order;
                viewRecordModalRoute.value = response.data.data.menu.route;
                viewRecordModalPermissions.value = response.data.data.menu.permissions;
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
                                        <option value="title" @if (old('sortBy') === 'title') selected @endif>Title
                                        </option>
                                        <option value="sub_title" @if (old('sortBy') === 'sub_title') selected @endif>
                                            Sub Title
                                        </option>
                                        <option value="route" @if (old('sortBy') === 'route') selected @endif>Route
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
                            <x-form-text-input id="addRecordModalTitle" label="Title" required />
                        </div>
                        <div class="col-md-6">
                            <x-form-text-input id="addRecordModalSubTitle" label="Sub Title" />
                        </div>
                        <div class="col-md-6">
                            <x-form-text-input id="addRecordModalIcon" label="Icon" required />
                        </div>
                        <div class="col-md-6">
                            <x-form-text-input id="addRecordModalSubIcon" label="Sub Icon" />
                        </div>
                        <div class="col-md-6">
                            <x-form-text-input id="addRecordModalOrder" label="Order" required />
                        </div>
                        <div class="col-md-6">
                            <x-form-text-input id="addRecordModalSubOrder" label="Sub Order" />
                        </div>
                        <div class="col-md-6">
                            <x-form-text-input id="addRecordModalRoute" label="Route" required />
                        </div>
                        <div class="col-md-6">
                            <x-form-text-input id="addRecordModalPermissions" label="Permissions" />
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
                            <x-form-text-input id="viewRecordModalTitle" label="Title" required disabled />
                        </div>
                        <div class="col-md-6">
                            <x-form-text-input id="viewRecordModalSubTitle" label="Sub Title" disabled />
                        </div>
                        <div class="col-md-6">
                            <x-form-text-input id="viewRecordModalIcon" label="Icon" required disabled />
                        </div>
                        <div class="col-md-6">
                            <x-form-text-input id="viewRecordModalSubIcon" label="Sub Icon" disabled />
                        </div>
                        <div class="col-md-6">
                            <x-form-text-input id="viewRecordModalOrder" label="Order" required disabled />
                        </div>
                        <div class="col-md-6">
                            <x-form-text-input id="viewRecordModalSubOrder" label="Sub Order" disabled />
                        </div>
                        <div class="col-md-6">
                            <x-form-text-input id="viewRecordModalRoute" label="Route" required disabled />
                        </div>
                        <div class="col-md-6">
                            <x-form-text-input id="viewRecordModalPermissions" label="Permissions" disabled />
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
                            <x-form-text-input id="updateRecordModalTitle" label="Title" required />
                        </div>
                        <div class="col-md-6">
                            <x-form-text-input id="updateRecordModalSubTitle" label="Sub Title" />
                        </div>
                        <div class="col-md-6">
                            <x-form-text-input id="updateRecordModalIcon" label="Icon" required />
                        </div>
                        <div class="col-md-6">
                            <x-form-text-input id="updateRecordModalSubIcon" label="Sub Icon" />
                        </div>
                        <div class="col-md-6">
                            <x-form-text-input id="updateRecordModalOrder" label="Order" required />
                        </div>
                        <div class="col-md-6">
                            <x-form-text-input id="updateRecordModalSubOrder" label="Sub Order" />
                        </div>
                        <div class="col-md-6">
                            <x-form-text-input id="updateRecordModalRoute" label="Route" required />
                        </div>
                        <div class="col-md-6">
                            <x-form-text-input id="updateRecordModalPermissions" label="Permissions" />
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
