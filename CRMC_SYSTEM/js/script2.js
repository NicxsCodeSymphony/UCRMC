const navbarMenu = document.querySelector(".navbar ul");
const hamburgerBtn = document.querySelector(".header .left-head");
const hideMenuBtn = document.querySelector(".navbar");
const showPopupBtn = document.querySelector(".login-btn");
const showPopupBtn1 = document.querySelector(".signup-btn");
const showPopupBtn2 = document.querySelector(".button-container-1");
const formPopup = document.querySelector(".form-popup");
const hidePopupBtn = formPopup.querySelector(".close-btn");
const signupLoginLink = formPopup.querySelectorAll(".bottom-link a");

// Show mobile menu
hamburgerBtn.addEventListener("click", () => {
    navbarMenu.classList.toggle("show-menu");
});

// Hide mobile menu
hideMenuBtn.addEventListener("click", () =>  hamburgerBtn.click());

// Show login popup
showPopupBtn.addEventListener("click", () => {
    document.body.classList.toggle("show-popup");
});

// Hide login popup
hidePopupBtn.addEventListener("click", () => showPopupBtn.click());

// Show or hide signup form
signupLoginLink.forEach(link => {
    link.addEventListener("click", (e) => {
        e.preventDefault();
        formPopup.classList[link.id === 'signup-link' ? 'add' : 'remove']("show-signup");
    });
});

// Show signup popup for .signup-btn
showPopupBtn1.addEventListener("click", () => {
    document.body.classList.toggle("show-popup");
});

// Show signup popup for .button-container-1
showPopupBtn2.addEventListener("click", () => {
    document.body.classList.toggle("show-popup");
});
