document.addEventListener("DOMContentLoaded", function() {

  document.getElementById("signupForm").addEventListener("submit", function(e) {
    e.preventDefault();
    const nom = document.getElementById("nom").value.trim();
    const prenom = document.getElementById("prenom").value.trim();

    if (nom && prenom) {
      localStorage.setItem("nom", nom);
      localStorage.setItem("prenom", prenom);
      window.location.href = "suivant.html";
    } else {
      document.getElementById("error").textContent =
        "Veuillez remplir tous les champs.";
    }
  });

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
});
