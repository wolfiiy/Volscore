// JavaScript pour gérer l'affichage de la modal
document.addEventListener('DOMContentLoaded', function() {
    var error = document.getElementById('errorMessage').dataset.error;
    if (error) {
        var modal = document.getElementById("myModal");
        var closeModal = document.getElementById("closeModal");
        var errorMessage = document.getElementById("errorMessage");
        errorMessage.textContent = error;

        modal.style.display = "block";

        closeModal.onclick = function() {
            modal.style.display = "none";
        }

        window.onclick = function(event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }
    }
});
