const menu = document.querySelector(".wrapper-icon i");
const menuSide = document.querySelector("nav .wrapper-icon i");
const nav = document.querySelector("nav");

menu.addEventListener("click", () => {
  nav.classList.toggle("close");
});

// dropdown
const img = document.querySelector(".user-profile img");
const dropdown = document.querySelector("header.first .dropdownMenu");

img.addEventListener("click", () => {
  dropdown.classList.toggle("active");
});
