// Toggle mobile nav
const hamburger = document.querySelector(".hamburger");
const navLinks = document.querySelector(".nav-links");

hamburger.addEventListener("click", () => {
  navLinks.classList.toggle("active");
});

// Dropdown toggle
const dropdown = document.querySelector(".dropdown");
const dropbtn = dropdown.querySelector(".dropbtn");

dropbtn.addEventListener("click", (e) => {
  e.preventDefault();
  dropdown.classList.toggle("show");
});

// Close dropdown if clicked outside
document.addEventListener("click", (e) => {
  if (!dropdown.contains(e.target) && !dropbtn.contains(e.target)) {
    dropdown.classList.remove("show");
  }
});
