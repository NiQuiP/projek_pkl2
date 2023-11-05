const menu = document.querySelector(".wrapper-icon i");
const nav = document.querySelector("nav");

const img = document.querySelector(".user-profile img");
const dropdown = document.querySelector("header.first .dropdownMenu");

const search = document.querySelector(".input-group input"),
  table_rows = document.querySelectorAll("tbody tr"),
  table_headings = document.querySelectorAll("thead th");

menu.addEventListener("click", () => {
  nav.classList.toggle("close");
});

table_headings.forEach((head, i) => {
  let sort_asc = true;
  head.onclick = () => {
    table_headings.forEach((head) => head.classList.remove("active"));
    head.classList.add("active");

    document.querySelectorAll("td").forEach((td) => td.classList.remove("active"));
    table_rows.forEach((row) => {
      row.querySelectorAll("td")[i].classList.add("active");
    });

    head.classList.toggle("asc", sort_asc);
    sort_asc = head.classList.contains("asc") ? false : true;

    sortTable(i, sort_asc);
  };
});

function sortTable(column, sort_asc) {
  [...table_rows]
    .sort((a, b) => {
      let first_row = a.querySelectorAll("td")[column].textContent.toLowerCase(),
        second_row = b.querySelectorAll("td")[column].textContent.toLowerCase();

      return sort_asc ? (first_row < second_row ? 1 : -1) : first_row < second_row ? -1 : 1;
    })
    .map((sorted_row) => document.querySelector("tbody").appendChild(sorted_row));
}

img.addEventListener("click", () => {
  dropdown.classList.toggle("active");
});

