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

// dropdown
const img = document.querySelector(".user-profile img");
const dropdown = document.querySelector("header.first .dropdownMenu");

img.addEventListener("click", () => {
  dropdown.classList.toggle("active");
});

const fileInput = document.getElementById("upload");
const preview = document.getElementById("preview");

fileInput.addEventListener("change", function () {
  const file = fileInput.files[0];

  if (file) {
    const reader = new FileReader();

    reader.onload = function (e) {
      // Menampilkan gambar yang dipilih dalam elemen img
      preview.src = e.target.result;
      preview.style.display = "block";
    };

    // Membaca file sebagai URL data
    reader.readAsDataURL(file);
  } else {
    // Mengosongkan elemen img jika tidak ada gambar yang dipilih
    preview.src = "#";
    preview.style.display = "none";
  }
});

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

const menu = document.querySelector(".wrapper-icon i");
const nav = document.querySelector("nav");

menu.addEventListener("click", () => {
  nav.classList.toggle("close");
});

function updateValue() {
  // Mendapatkan elemen <select> berdasarkan ID
  var selectElement = document.getElementById('menu');
  
  // Mendapatkan nilai terpilih (value) dari elemen <select>
  var selectedValue = selectElement.value;
  
  // Mengisi nilai terpilih ke dalam elemen <input> yang tersembunyi
  document.getElementById('selected_menu').value = selectedValue;
}

