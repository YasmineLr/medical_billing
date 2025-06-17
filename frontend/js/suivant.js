document.addEventListener("DOMContentLoaded", function() {
  fetch("../pages/header.html")
    .then((res) => res.text())
    .then((data) => {
      document.getElementById("header-placeholder").innerHTML = data;
    });

  fetch("../pages/footer.html")
    .then((res) => res.text())
    .then((data) => {
      document.getElementById("footer-placeholder").innerHTML = data;
    });
    window.addEventListener("click", function (e) {
      document.querySelectorAll(".dropdown").forEach(dropdown => {
        if (!dropdown.contains(e.target)) {
          dropdown.classList.remove("open");
        }
      });
    });
});
