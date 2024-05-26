@extends('layouts.app')

@section('page_title')
    Users
@endsection

@php
    $bulkUpdateUrl = route('users.bulkUpdate');
    $bulkDestroyUrl = route('users.bulkDestroy');
    $filterResetUrl = route('users.index');
    $deleteRecordUrl = route('users.destroy', ['user' => '#PH']);
    $addRecordUrl = route('users.store');
    $editRecordUrl = route('users.edit', ['user' => '#PH']);
    $updateRecordUrl = route('users.update', ['user' => '#PH']);
    $viewRecordUrl = route('users.show', ['user' => '#PH']);
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
                    @can(['CREATE_USER'])
                        <button class="icon-btn mr-2 btn btn-sm btn-primary" title="Add Record"
                            onclick="onAddRecordButtonClick();">
                            <i class="fas fa-plus"></i>
                        </button>
                    @endcan
                    @can(['IMPORT_USER'])
                        <button class="icon-btn mr-2 btn btn-sm btn-info" title="Import Records"
                            onclick="onImportRecordsButtonClick();">
                            <i class="fas fa-download"></i>
                        </button>
                    @endcan
                    @can(['EXPORT_USER'])
                        <button class="icon-btn mr-2 btn btn-sm btn-success" title="Export Records"
                            onclick="onExportRecordsButtonClick();">
                            <i class="fas fa-upload"></i>
                        </button>
                    @endcan
                </div>
                <div>
                    @can(['BULK_UPDATE_USER'])
                        <button class="icon-btn mr-2 btn btn-sm btn-warning" title="Bulk Change Status"
                            onclick="onBulkChangeStatusClick('{{ $bulkUpdateUrl }}');">
                            <i class="fas fa-recycle"></i>
                        </button>
                    @endcan
                    @can(['BULK_DELETE_USER'])
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
                        <th>Image</th>
                        <th>Name</th>
                        <th>Role</th>
                        <th>Username</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($userList as $user)
                        <tr>
                            <td>
                                <input type="checkbox" name="selectOne{{ $user->id }}"
                                    id="selectOne{{ $user->id }}">
                            </td>
                            <td>{{ $userList->firstItem() + $loop->index }}</td>
                            <td>
                                @if ($user->image)
                                    <img style="display: inline-block; width: 24px; height: auto; border-radius: 50%;"
                                        src="{{ asset('storage/' . $user->image) }}" alt="{{ $user->name }}">
                                @else
                                    <img style="display: inline-block; width: 24px; height: auto; border-radius: 50%;"
                                        src="{{ asset($user->gender === 'Male' ? 'assets/images/default/user_image_male.jpg' : 'assets/images/default/user_image_female.jpg') }}"
                                        alt="{{ $user->name }}">
                                @endif
                            </td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->getRoleNames()->join(', ') }}</td>
                            <td>{{ $user->username }}</td>
                            <td>
                                @if ($user->is_active)
                                    <span class="badge badge-pill badge-success small text-uppercase">Active</span>
                                @else
                                    <span class="badge badge-pill badge-danger small text-uppercase">Inactive</span>
                                @endif
                            </td>
                            <td>
                                @can(['READ_USER'])
                                    <button class="icon-btn mb-2 mr-0 mb-md-0 mr-md-2 btn btn-sm btn-primary"
                                        title="View Record" onclick="onViewRecordButtonClick({{ $user->id }});">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                @endcan
                                @can(['UPDATE_USER'])
                                    <button class="icon-btn mb-2 mr-0 mb-md-0 mr-md-2 btn btn-sm btn-info" title="Change Status"
                                        onclick="sendChangeStatusRequest('{{ $bulkUpdateUrl }}', {{ $user->id }});">
                                        <i class="fas fa-recycle"></i>
                                    </button>
                                @endcan
                                @can(['UPDATE_USER'])
                                    <button class="icon-btn mb-2 mr-0 mb-md-0 mr-md-2 btn btn-sm btn-warning"
                                        title="Update Record" onclick="onUpdateRecordButtonClick({{ $user->id }});">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                @endcan
                                @can(['DELETE_USER'])
                                    <button class="icon-btn mb-2 mr-0 mb-md-0 mr-md-2 btn btn-sm btn-danger"
                                        title="Delete Record"
                                        onclick="onDeleteRecordClick('{{ $deleteRecordUrl }}', {{ $user->id }});">
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
                        <th>Image</th>
                        <th>Name</th>
                        <th>Role</th>
                        <th>Username</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </tfoot>
            </table>
        </div>
        <div class="card-footerr">
            <div class="d-flex justify-content-between align-items-center p-4 flex-column flex-md-row">
                <div class="mb-2 mb-md-0">
                    Showing {{ $userList->firstItem() }} to {{ $userList->lastItem() }} of {{ $userList->total() }}
                    entries
                </div>
                <div class="mb-2 mb-md-0">
                    {{ $userList->onEachSide(1)->links('pagination::bootstrap-4') }}
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
            let addRecordModalGender = document.querySelector("#addRecordModalGender");
            let addRecordModalEmail = document.querySelector("#addRecordModalEmail");
            let addRecordModalUsername = document.querySelector("#addRecordModalUsername");
            let addRecordModalMobileNumber = document.querySelector("#addRecordModalMobileNumber");
            let addRecordModalPassword = document.querySelector("#addRecordModalPassword");
            let addRecordModalRole = document.querySelector("#addRecordModalRole");
            let addRecordModalImage = document.querySelector("#addRecordModalImage");

            if (clearModalAlerts) {
                hideModalAlert('addRecordModal', 'success');
                hideModalAlert('addRecordModal', 'danger');
            }
            addRecordModalName.value = "";
            addRecordModalGender.value = "";
            addRecordModalEmail.value = "";
            addRecordModalUsername.value = "";
            addRecordModalMobileNumber.value = "";
            addRecordModalPassword.value = "";
            addRecordModalRole.value = "";
            addRecordModalImage.value = "";

            let currentFieldPreview = document.querySelector(
                `#addRecordModalImagePreview`
            );
            if (currentFieldPreview) {
                currentFieldPreview.innerHTML = `<p>No Image Selected</p>`;
            }
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
            let addRecordModalGender = document.querySelector("#addRecordModalGender");
            let addRecordModalEmail = document.querySelector("#addRecordModalEmail");
            let addRecordModalUsername = document.querySelector("#addRecordModalUsername");
            let addRecordModalMobileNumber = document.querySelector("#addRecordModalMobileNumber");
            let addRecordModalPassword = document.querySelector("#addRecordModalPassword");
            let addRecordModalRole = document.querySelector("#addRecordModalRole");
            let addRecordModalImage = document.querySelector("#addRecordModalImage");

            let requestUrl = "{{ $addRecordUrl }}";
            let requestData = new FormData();
            requestData.append("name", addRecordModalName.value);
            requestData.append("gender", addRecordModalGender.value);
            requestData.append("email", addRecordModalEmail.value);
            requestData.append("username", addRecordModalUsername.value);
            requestData.append("mobile_number", addRecordModalMobileNumber.value);
            requestData.append("password", addRecordModalPassword.value);
            requestData.append("role", addRecordModalRole.value);
            if (addRecordModalImage.files[0]) {
                requestData.append("image", addRecordModalImage.files[0]);
            }

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
            let updateRecordModalGender = document.querySelector("#updateRecordModalGender");
            let updateRecordModalEmail = document.querySelector("#updateRecordModalEmail");
            let updateRecordModalUsername = document.querySelector("#updateRecordModalUsername");
            let updateRecordModalMobileNumber = document.querySelector("#updateRecordModalMobileNumber");
            let updateRecordModalPassword = document.querySelector("#updateRecordModalPassword");
            let updateRecordModalRole = document.querySelector("#updateRecordModalRole");
            let updateRecordModalImage = document.querySelector("#updateRecordModalImage");

            if (clearModalAlerts) {
                hideModalAlert('updateRecordModal', 'success');
                hideModalAlert('updateRecordModal', 'danger');
            }
            updateRecordModalId.value = "";
            updateRecordModalName.value = "";
            updateRecordModalGender.value = "";
            updateRecordModalEmail.value = "";
            updateRecordModalUsername.value = "";
            updateRecordModalMobileNumber.value = "";
            updateRecordModalPassword.value = "";
            updateRecordModalRole.value = "";
            updateRecordModalImage.value = "";

            let currentFieldPreview = document.querySelector(
                `#updateRecordModalImagePreview`
            );
            if (currentFieldPreview) {
                currentFieldPreview.innerHTML = `<p>No Image Selected</p>`;
            }
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
                let updateRecordModalGender = document.querySelector("#updateRecordModalGender");
                let updateRecordModalEmail = document.querySelector("#updateRecordModalEmail");
                let updateRecordModalUsername = document.querySelector("#updateRecordModalUsername");
                let updateRecordModalMobileNumber = document.querySelector("#updateRecordModalMobileNumber");
                let updateRecordModalPassword = document.querySelector("#updateRecordModalPassword");
                let updateRecordModalRole = document.querySelector("#updateRecordModalRole");

                updateRecordModalName.value = response.data.data.user.name;
                updateRecordModalGender.value = response.data.data.user.gender;
                updateRecordModalEmail.value = response.data.data.user.email;
                updateRecordModalUsername.value = response.data.data.user.username;
                updateRecordModalMobileNumber.value = response.data.data.user.mobile_number;
                updateRecordModalPassword.value = "#OLD_PASSWORD";
                updateRecordModalRole.value = response.data.data.user.roles[0].id;

                let currentFieldPreview = document.querySelector(
                    `#updateRecordModalImagePreview`
                );
                if (!response.data.data.user.image) {
                    currentFieldPreview.innerHTML =
                        `<img class="d-block w-100 h-auto" src="${response.data.data.user.gender === 'Male' ? 'assets/images/default/user_image_male.jpg' : 'assets/images/default/user_image_female.jpg'}" alt="Preview Image">`;
                } else {
                    currentFieldPreview.innerHTML =
                        `<img class="d-block w-100 h-auto" src="${'storage/' + response.data.data.user.image}" alt="Preview Image">`;
                }
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
            let updateRecordModalGender = document.querySelector("#updateRecordModalGender");
            let updateRecordModalEmail = document.querySelector("#updateRecordModalEmail");
            let updateRecordModalUsername = document.querySelector("#updateRecordModalUsername");
            let updateRecordModalMobileNumber = document.querySelector("#updateRecordModalMobileNumber");
            let updateRecordModalPassword = document.querySelector("#updateRecordModalPassword");
            let updateRecordModalRole = document.querySelector("#updateRecordModalRole");
            let updateRecordModalImage = document.querySelector("#updateRecordModalImage");

            let requestUrl = "{{ $updateRecordUrl }}";
            requestUrl = requestUrl.replace("#PH", updateRecordModalId.value);
            let requestData = new FormData();
            requestData.append("name", updateRecordModalName.value);
            requestData.append("gender", updateRecordModalGender.value);
            requestData.append("email", updateRecordModalEmail.value);
            requestData.append("username", updateRecordModalUsername.value);
            requestData.append("mobile_number", updateRecordModalMobileNumber.value);
            requestData.append("password", updateRecordModalPassword.value);
            requestData.append("role", updateRecordModalRole.value);
            if (updateRecordModalImage.files[0]) {
                requestData.append("image", updateRecordModalImage.files[0]);
            }

            requestData.append("_method", "PUT");
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
            let viewRecordModalGender = document.querySelector("#viewRecordModalGender");
            let viewRecordModalEmail = document.querySelector("#viewRecordModalEmail");
            let viewRecordModalUsername = document.querySelector("#viewRecordModalUsername");
            let viewRecordModalMobileNumber = document.querySelector("#viewRecordModalMobileNumber");
            let viewRecordModalPassword = document.querySelector("#viewRecordModalPassword");
            let viewRecordModalRole = document.querySelector("#viewRecordModalRole");
            let viewRecordModalImage = document.querySelector("#viewRecordModalImage");

            if (clearModalAlerts) {
                hideModalAlert('viewRecordModal', 'success');
                hideModalAlert('viewRecordModal', 'danger');
            }
            viewRecordModalId.value = "";
            viewRecordModalName.value = "";
            viewRecordModalGender.value = "";
            viewRecordModalEmail.value = "";
            viewRecordModalUsername.value = "";
            viewRecordModalMobileNumber.value = "";
            viewRecordModalPassword.value = "";
            viewRecordModalRole.value = "";
            viewRecordModalImage.value = "";

            let currentFieldPreview = document.querySelector(
                `#viewRecordModalImagePreview`
            );
            if (currentFieldPreview) {
                currentFieldPreview.innerHTML = `<p>No Image Selected</p>`;
            }
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
                let viewRecordModalGender = document.querySelector("#viewRecordModalGender");
                let viewRecordModalEmail = document.querySelector("#viewRecordModalEmail");
                let viewRecordModalUsername = document.querySelector("#viewRecordModalUsername");
                let viewRecordModalMobileNumber = document.querySelector("#viewRecordModalMobileNumber");
                let viewRecordModalPassword = document.querySelector("#viewRecordModalPassword");
                let viewRecordModalRole = document.querySelector("#viewRecordModalRole");

                viewRecordModalName.value = response.data.data.user.name;
                viewRecordModalGender.value = response.data.data.user.gender;
                viewRecordModalEmail.value = response.data.data.user.email;
                viewRecordModalUsername.value = response.data.data.user.username;
                viewRecordModalMobileNumber.value = response.data.data.user.mobile_number;
                viewRecordModalPassword.value = "#OLD_PASSWORD";
                viewRecordModalRole.value = response.data.data.user.roles[0].id;

                let currentFieldPreview = document.querySelector(
                    `#viewRecordModalImagePreview`
                );
                if (!response.data.data.user.image) {
                    currentFieldPreview.innerHTML =
                        `<img class="d-block w-100 h-auto" src="${response.data.data.user.gender === 'Male' ? 'assets/images/default/user_image_male.jpg' : 'assets/images/default/user_image_female.jpg'}" alt="Preview Image">`;
                } else {
                    currentFieldPreview.innerHTML =
                        `<img class="d-block w-100 h-auto" src="${'storage/' + response.data.data.user.image}" alt="Preview Image">`;
                }
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
                                        <option value="email" @if (old('sortBy') === 'email') selected @endif>Email
                                        </option>
                                        <option value="username" @if (old('sortBy') === 'username') selected @endif>Username
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
                            <x-form-text-input id="addRecordModalName" label="Name" required placeholder="John Doe" />
                        </div>
                        <div class="col-md-6">
                            <x-form-select id="addRecordModalGender" label="Gender" required :options="[
                                ['label' => 'Male', 'value' => 'Male'],
                                ['label' => 'Female', 'value' => 'Female'],
                            ]" />
                        </div>
                        <div class="col-md-6">
                            <x-form-text-input id="addRecordModalEmail" label="Email" required type="email"
                                placeholder="johndoe@example.com" />
                        </div>
                        <div class="col-md-6">
                            <x-form-text-input id="addRecordModalUsername" label="Username" required
                                placeholder="johndoe" />
                        </div>
                        <div class="col-md-6">
                            <x-form-text-input id="addRecordModalMobileNumber" label="Mobile Number" :required="false"
                                placeholder="XXXXXXXXXX" />
                        </div>
                        <div class="col-md-6">
                            <x-form-password-input id="addRecordModalPassword" label="Password" required
                                placeholder="********" icon_id="addRecordModalPasswordIcon" />
                        </div>
                        <div class="col-md-6">
                            @php
                                $roleOptions = collect([]);
                                foreach ($roleList as $role) {
                                    $roleOptions->push(['label' => $role->name, 'value' => $role->id]);
                                }
                            @endphp
                            <x-form-select id="addRecordModalRole" label="Role" required :options="$roleOptions" />
                        </div>
                        <div class="col-md-6">
                            <x-form-file-input id="addRecordModalImage" label="Image" :required="false"
                                previewContainerId="addRecordModalImagePreview" />
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
                            <x-form-text-input id="viewRecordModalName" label="Name" required placeholder="John Doe"
                                disabled />
                        </div>
                        <div class="col-md-6">
                            <x-form-select id="viewRecordModalGender" label="Gender" required :options="[
                                ['label' => 'Male', 'value' => 'Male'],
                                ['label' => 'Female', 'value' => 'Female'],
                            ]"
                                disabled />
                        </div>
                        <div class="col-md-6">
                            <x-form-text-input id="viewRecordModalEmail" label="Email" required type="email"
                                placeholder="johndoe@example.com" disabled />
                        </div>
                        <div class="col-md-6">
                            <x-form-text-input id="viewRecordModalUsername" label="Username" required
                                placeholder="johndoe" disabled />
                        </div>
                        <div class="col-md-6">
                            <x-form-text-input id="viewRecordModalMobileNumber" label="Mobile Number" :required="false"
                                placeholder="XXXXXXXXXX" disabled />
                        </div>
                        <div class="col-md-6">
                            <x-form-password-input id="viewRecordModalPassword" label="Password" required
                                placeholder="********" icon_id="viewRecordModalPasswordIcon" disabled />
                        </div>
                        <div class="col-md-6">
                            @php
                                $roleOptions = collect([]);
                                foreach ($roleList as $role) {
                                    $roleOptions->push(['label' => $role->name, 'value' => $role->id]);
                                }
                            @endphp
                            <x-form-select id="viewRecordModalRole" label="Role" required :options="$roleOptions" disabled />
                        </div>
                        <div class="col-md-6">
                            <x-form-file-input id="viewRecordModalImage" label="Image" :required="false"
                                previewContainerId="viewRecordModalImagePreview" disabled />
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
                            <x-form-text-input id="updateRecordModalName" label="Name" required
                                placeholder="John Doe" />
                        </div>
                        <div class="col-md-6">
                            <x-form-select id="updateRecordModalGender" label="Gender" required :options="[
                                ['label' => 'Male', 'value' => 'Male'],
                                ['label' => 'Female', 'value' => 'Female'],
                            ]" />
                        </div>
                        <div class="col-md-6">
                            <x-form-text-input id="updateRecordModalEmail" label="Email" required type="email"
                                placeholder="johndoe@example.com" />
                        </div>
                        <div class="col-md-6">
                            <x-form-text-input id="updateRecordModalUsername" label="Username" required
                                placeholder="johndoe" />
                        </div>
                        <div class="col-md-6">
                            <x-form-text-input id="updateRecordModalMobileNumber" label="Mobile Number" :required="false"
                                placeholder="XXXXXXXXXX" />
                        </div>
                        <div class="col-md-6">
                            <x-form-password-input id="updateRecordModalPassword" label="Password" required
                                placeholder="********" icon_id="updateRecordModalPasswordIcon" />
                        </div>
                        <div class="col-md-6">
                            @php
                                $roleOptions = collect([]);
                                foreach ($roleList as $role) {
                                    $roleOptions->push(['label' => $role->name, 'value' => $role->id]);
                                }
                            @endphp
                            <x-form-select id="updateRecordModalRole" label="Role" required :options="$roleOptions" />
                        </div>
                        <div class="col-md-6">
                            <x-form-file-input id="updateRecordModalImage" label="Image" :required="false"
                                previewContainerId="updateRecordModalImagePreview" />
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
