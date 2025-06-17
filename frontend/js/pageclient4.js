
document.addEventListener("DOMContentLoaded", function () {
  const form = document.getElementById("rdvForm");

  form.addEventListener("submit", function (e) {
    e.preventDefault();

    const soignant = document.getElementById("hiddenSoignantInput").value;
    const service = document.getElementById("hiddenServiceInput").value;

    if (!soignant || !service) {
      alert("Veuillez sélectionner un soignant et un service.");
      return;
    }

    const formData = new FormData();
    formData.append("soignant", soignant);
    formData.append("service", service);

    fetch("../../backend/enregistrer_rendezvous.php", {
      method: "POST",
      body: formData,
    })
      .then((response) => response.json()) // Le PHP doit renvoyer du JSON
      .then((data) => {
        if (data.success) {
          window.location.href = "../paiement.html";
        } else {
          alert("Erreur : " + data.message);
        }
      })
      .catch((error) => {
        console.error("Erreur :", error);
        alert("Erreur de communication avec le serveur.");
      });
  });
});
