document.addEventListener('DOMContentLoaded', function() {
    let menuDropdownList = document.querySelector(".menu-dropdown .menu-dropdown-list");
    let btn = document.querySelector(".menu-dropdown-btn");

    const toggle = () => menuDropdownList.classList.toggle("active");

    btn.addEventListener('click', toggle);
});