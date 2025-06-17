document.addEventListener("DOMContentLoaded", function() {
<<<<<<< HEAD
=======

        document.getElementById("finalForm").addEventListener("submit", function (e) {
    e.preventDefault();
    const age = document.getElementById("age").value.trim();
    const sexe = document.getElementById("sexe").value;
    const tel = document.getElementById("tel").value.trim();
    const adresse = document.getElementById("adresse").value.trim();
    const email = document.getElementById("email").value.trim();
    const code = document.getElementById("code").value.trim();
    const confirmCode = document.getElementById("confirmCode").value.trim();

    if (
      !age ||
      !sexe ||
      !tel ||
      !adresse ||
      !email ||
      !code ||
      !confirmCode
    ) {
      document.getElementById("error").textContent =
        "Veuillez remplir tous les champs.";
    } else if (code !== confirmCode) {
      document.getElementById("error").textContent =
        "Les codes ne correspondent pas.";
    } else {
      const nom = localStorage.getItem("nom");
      const prenom = localStorage.getItem("prenom");

      fetch("/medical_billing/backend/add_patient.php", {
        method: "POST",
        headers: {
          "Content-Type": "application/x-www-form-urlencoded",
        },
        body: `nom=${encodeURIComponent(nom)}
        &prenom=${encodeURIComponent(prenom)}
        &age=${encodeURIComponent(age)}
        &tel=${encodeURIComponent(tel)}
        &adresse=${encodeURIComponent(adresse)}
        &email=${encodeURIComponent(email)}
        &mot_de_passe=${encodeURIComponent(code)}`,
      })
        .then((response) => response.json())
        .then((data) => {
          if (data.success) {
            localStorage.removeItem("nom");
            localStorage.removeItem("prenom");
            window.location.href = "pageconnexion.html";
          } else {
            document.getElementById("error").textContent =
              data.message || "Erreur lors de l'inscription.";
          }
        })
        .catch((error) => {
          console.error("Erreur :", error);
          document.getElementById("error").textContent =
            "Erreur de communication avec le serveur.";
        });
    }
  });
>>>>>>> 70ae5ef39fefdbb7e4b2ada10dedc58e1e2f2541
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
<<<<<<< HEAD
    window.addEventListener("click", function (e) {
      document.querySelectorAll(".dropdown").forEach(dropdown => {
        if (!dropdown.contains(e.target)) {
          dropdown.classList.remove("open");
        }
      });
    });
=======
>>>>>>> 70ae5ef39fefdbb7e4b2ada10dedc58e1e2f2541
});
