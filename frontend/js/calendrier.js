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

      const dateInput = document.getElementById("date");
      const today = new Date();
      const tomorrow = new Date(today);
      tomorrow.setDate(today.getDate() + 1);

      dateInput.min = today.toISOString().split("T")[0];

      dateInput.addEventListener("change", function () {
        const selectedDate = new Date(this.value);
        const isSunday = selectedDate.getDay() === 0;
        const isTomorrow =
          selectedDate.toDateString() === tomorrow.toDateString();

        if (isSunday || isTomorrow) {
          alert(
            "Cette date n'est pas disponible. Veuillez en choisir une autre."
          );
          this.value = "";
        }
      });

      document
        .getElementById("rdvForm")
        .addEventListener("submit", function (e) {
          e.preventDefault();
<<<<<<< HEAD
          window.location.href = "pageclient2.html";
=======
          document.getElementById("message").style.display = "block";
>>>>>>> 70ae5ef39fefdbb7e4b2ada10dedc58e1e2f2541
        });
});
