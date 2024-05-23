let selectAllHead = document.querySelector("#selectAllHead");
let selectAllFoot = document.querySelector("#selectAllFoot");
let selectOne = document.querySelectorAll("[id*='selectOne']");
let csrfToken = document.querySelector("meta[name='csrf-token']").content;

selectAllHead.addEventListener("change", function (event) {
    let newCheckboxState = event.target.checked;
    selectAllFoot.checked = newCheckboxState;
    selectOne.forEach((el) => (el.checked = newCheckboxState));
});
selectAllFoot.addEventListener("change", function (event) {
    let newCheckboxState = event.target.checked;
    selectAllHead.checked = newCheckboxState;
    selectOne.forEach((el) => (el.checked = newCheckboxState));
});
selectOne.forEach((el) =>
    el.addEventListener("change", function (event) {
        selectAllHead.checked = false;
        selectAllFoot.checked = false;
    })
);

function getSelectedItems() {
    let selectedItems = [];
    selectOne.forEach((el) => {
        if (el.checked) {
            selectedItems.push(+el.id.replace("selectOne", ""));
        }
    });
    return selectedItems;
}

// BULK UPDATE
function onBulkChangeStatusClick(bulkUpdateUrl) {
    let selectedItems = getSelectedItems();
    if (selectedItems.length === 0) {
        alert("Please select at-least one item to perform this bulk action.");
        return;
    }
    let userResponse = confirm(
        `Are you sure, you want to update ${selectedItems.length} records?`
    );
    if (userResponse) {
        sendBulkChangeStatusRequest(bulkUpdateUrl, selectedItems);
    }
}

async function sendBulkChangeStatusRequest(bulkUpdateUrl, selectedItems) {
    try {
        let response = await axios.patch(
            bulkUpdateUrl,
            {
                selectedItems,
            },
            {
                headers: {
                    "X-Requested-With": "XMLHttpRequest",
                    "Content-Type": "application/json",
                    Accept: "application/json",
                    "X-CSRF-TOKEN": csrfToken,
                },
            }
        );
        alert(response.data.message);
        window.location.reload();
    } catch (error) {
        console.log(error);
        alert("Something went wrong, please try again later!");
    }
}

// BULK DELETE
function onBulkDeleteRecordsClick(bulkDeleteUrl) {
    let selectedItems = getSelectedItems();
    if (selectedItems.length === 0) {
        alert("Please select at-least one item to perform this bulk action.");
        return;
    }
    let userResponse = confirm(
        `Are you sure, you want to delete ${selectedItems.length} records?`
    );
    if (userResponse) {
        sendBulkDeleteRequest(bulkDeleteUrl, selectedItems);
    }
}

async function sendBulkDeleteRequest(bulkDeleteUrl, selectedItems) {
    try {
        let response = await axios.delete(bulkDeleteUrl, {
            headers: {
                "X-Requested-With": "XMLHttpRequest",
                "Content-Type": "application/json",
                Accept: "application/json",
                "X-CSRF-TOKEN": csrfToken,
            },
            data: {
                selectedItems,
            },
        });
        alert(response.data.message);
        window.location.reload();
    } catch (error) {
        console.log(error);
        alert("Something went wrong, please try again later!");
    }
}

// FILTER RESET
function onFilterRecordsModalResetClick(filterResetUrl) {
    window.location.href = filterResetUrl;
}

// CHANGE STATUS
async function sendChangeStatusRequest(bulkUpdateUrl, selectedItem) {
    try {
        let response = await axios.patch(
            bulkUpdateUrl,
            {
                selectedItems: [selectedItem],
            },
            {
                headers: {
                    "X-Requested-With": "XMLHttpRequest",
                    "Content-Type": "application/json",
                    Accept: "application/json",
                    "X-CSRF-TOKEN": csrfToken,
                },
            }
        );
        alert(response.data.message);
        window.location.reload();
    } catch (error) {
        console.log(error);
        alert("Something went wrong, please try again later!");
    }
}

// DELETE RECORD
function onDeleteRecordClick(deleteUrl, selectedItem) {
    let userResponse = confirm(
        `Are you sure, you want to delete current record?`
    );
    if (userResponse) {
        sendDeleteRequest(deleteUrl, selectedItem);
    }
}

async function sendDeleteRequest(deleteUrl, selectedItem) {
    try {
        let deleteUrlModified = deleteUrl.replace("#PH", selectedItem);
        let response = await axios.delete(deleteUrlModified, {
            headers: {
                "X-Requested-With": "XMLHttpRequest",
                "Content-Type": "application/json",
                Accept: "application/json",
                "X-CSRF-TOKEN": csrfToken,
            },
        });
        alert(response.data.message);
        window.location.reload();
    } catch (error) {
        console.log(error);
        alert("Something went wrong, please try again later!");
    }
}

// TOGGLE MODAL ALERT
const showModalAlert = (modalId, alertType, message) => {
    let modalAlertEl = document.querySelector(
        `#${modalId} ${
            alertType === "success" ? ".alert-success" : ".alert-danger"
        }`
    );
    let modalAlertMessageBoxEl = document.querySelector(
        `#${modalId} ${
            alertType === "success" ? ".alert-success" : ".alert-danger"
        } div`
    );
    modalAlertEl.classList.remove("d-none");
    modalAlertMessageBoxEl.innerHTML = message;
};

const hideModalAlert = (modalId, alertType) => {
    let modalAlertEl = document.querySelector(
        `#${modalId} ${
            alertType === "success" ? ".alert-success" : ".alert-danger"
        }`
    );
    let modalAlertMessageBoxEl = document.querySelector(
        `#${modalId} ${
            alertType === "success" ? ".alert-success" : ".alert-danger"
        } div`
    );
    modalAlertEl.classList.add("d-none");
    modalAlertMessageBoxEl.innerHTML = "";
};
