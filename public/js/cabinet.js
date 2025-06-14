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

          if (window.location.hash === "#footer") {
            const target = document.getElementById("footer");
            if (target) {
              target.scrollIntoView({ behavior: "smooth" });
            }
          }
        });
});
