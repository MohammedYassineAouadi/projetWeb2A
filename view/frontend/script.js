const form = document.getElementById("reclamationForm");
const reclamationsList = document.getElementById("reclamationsList");

form.addEventListener("submit", function (e) {
    e.preventDefault();

    const sujet = document.getElementById("sujet").value;
    const categorie = document.getElementById("categorie").value;
    const message = document.getElementById("message").value;

    // Vérification des champs
    if (!sujet || !categorie || !message) {
        alert("Tous les champs doivent être remplis !");
        return; // Empêche la soumission du formulaire
    }

    const date = new Date().toLocaleDateString();

    const reclamationHTML = `
    <div class="announcement-card">
      <h3>${sujet}</h3>
      <p><strong>Date :</strong> ${date}</p>
      <p><strong>Catégorie :</strong> ${categorie}</p>
      <p>${message}</p>
    </div>
    `;

    reclamationsList.insertAdjacentHTML("afterbegin", reclamationHTML);

    form.reset();
});
