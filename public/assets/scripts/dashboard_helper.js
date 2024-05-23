const onThemeSwitchClick = (event) => {
    event.preventDefault();
    const themeSwitchIconEl = document.querySelector("#themeSwitchIcon");
    const currentTheme = themeSwitchIconEl.classList.contains("fa-sun")
        ? "dark"
        : "light";
    switchTheme(currentTheme === "dark" ? "light" : "dark", themeSwitchIconEl);
};

const switchTheme = (newTheme, themeSwitchIconEl) => {
    localStorage.setItem("currentTheme", newTheme);
    if (newTheme === "dark") {
        document.body.classList.add("dark-mode");
        themeSwitchIconEl.classList.add("fa-sun");
        themeSwitchIconEl.classList.remove("fa-moon");
    } else {
        document.body.classList.remove("dark-mode");
        themeSwitchIconEl.classList.add("fa-moon");
        themeSwitchIconEl.classList.remove("fa-sun");
    }
};

const setNewThemeFromLocalStorage = () => {
    const themeSwitchIconEl = document.querySelector("#themeSwitchIcon");
    const currentTheme = localStorage.getItem("currentTheme");
    switchTheme(currentTheme, themeSwitchIconEl);
};
setNewThemeFromLocalStorage();

const onLogoutClick = (event) => {
    event.preventDefault();
    const logoutFormEl = document.querySelector("#logoutForm");
    const userConfirmation = confirm("Are you sure, you want to logged out?");
    if (userConfirmation) {
        logoutFormEl.submit();
    }
};
