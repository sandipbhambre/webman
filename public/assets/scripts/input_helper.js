const onPasswordHelpClick = (event, passwordId, passwordIconId) => {
    event.preventDefault();
    let passwordEl = document.querySelector(`#${passwordId}`);
    let passwordIconEl = document.querySelector(`#${passwordIconId}`);

    if (passwordEl.type === "password") {
        passwordEl.type = "text";
        passwordIconEl.classList.remove("fa-eye");
        passwordIconEl.classList.add("fa-eye-slash");
    } else {
        passwordEl.type = "password";
        passwordIconEl.classList.remove("fa-eye-slash");
        passwordIconEl.classList.add("fa-eye");
    }
};

const onSelectFileClick = (event, fileInputId) => {
    event.preventDefault();
    let fileInputEl = document.querySelector(`#${fileInputId}`);
    fileInputEl.click();
};

const onSelectFileChange = (event, imagePreviewContainerId) => {
    let imagePreviewContainerEl = document.querySelector(
        `#${imagePreviewContainerId}`
    );
    let file = event.srcElement.files[0];
    if (file) {
        const reader = new FileReader();
        reader.readAsDataURL(file);
        reader.onload = function (e) {
            imagePreviewContainerEl.innerHTML = `<img class="d-block w-100 h-auto" src="${e.target.result}" alt="Preview Image" />`;
        };
    } else {
        imagePreviewContainerEl.innerHTML = `<p>No Image Selected</p>`;
    }
};
