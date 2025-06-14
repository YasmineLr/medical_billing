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

      document.getElementById("loginForm").addEventListener("submit", function (e) {
          e.preventDefault();
          const email = document.getElementById("email").value.trim();
          const password = document.getElementById("password").value.trim();

          fetch("/medical_billing/backend/check_login.php", {
            method: "POST",
            headers: {
              "Content-Type": "application/x-www-form-urlencoded",
            },
            body: `email=${encodeURIComponent(email)}&password=${encodeURIComponent(password)}`,})
            .then((response) => response.json())
            .then((data) => {
            console.log(email);
            console.log(password);
              if (data.success) {
                window.location.href = "pageequipe.html";
              } else {
                document.getElementById("error").textContent =
                  "Identifiants incorrects.";
              }
            })
            .catch((error) => {
              console.error("Erreur :", error);
              document.getElementById("error").textContent =
                "Erreur de communication avec le serveur.";
            });
        });
        window.addEventListener("load", () => {
            document.getElementById("loginForm").reset();
        });
});
