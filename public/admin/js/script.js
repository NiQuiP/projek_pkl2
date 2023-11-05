// Tanggal
let dateToday = document.getElementById("date-today");

let today = new Date();
let day = `${today.getDate() < 10 ? "0" : ""}${today.getDate()}`;

let month = `${today.getMonth() + 1 < 10 ? "0" : ""}${today.getMonth() + 1}`;
let year = today.getFullYear();

dateToday.textContent = `${day} / ${month} / ${year}`;

// Waktu
let time = document.getElementById("current-time");

setInterval(() => {
  let d = new Date();
  time.innerHTML = d.toLocaleTimeString();
}, 1000);


// maps

const getLocationButton = document.getElementById("getLocation");
const latitudeInput = document.getElementById("latitude");
const longitudeInput = document.getElementById("longitude");

if (navigator.geolocation) {
  navigator.geolocation.getCurrentPosition(function (position) {
    const latitude = position.coords.latitude;
    const longitude = position.coords.longitude;

    // Memasukkan nilai latitude dan longitude ke dalam input
    latitudeInput.value = latitude;
    longitudeInput.value = longitude;
    var map = L.map("map").setView([latitude, longitude], 130);
    L.tileLayer("https://tile.openstreetmap.org/{z}/{x}/{y}.png", {
      maxZoom: 18,
    }).addTo(map);
    var marker = L.marker([latitude, longitude]).addTo(map);
  });
}

// select
// document.getElementById("select").selectedIndex = 0;

const menu = document.querySelector(".wrapper-icon i");
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
