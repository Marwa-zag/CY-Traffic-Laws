// Écouter l'événement de chargement du DOM
document.addEventListener("DOMContentLoaded", function() {
    // Sélectionner la section où afficher les scores
    const scoreSection = document.getElementById('score-section');

    // Récupérer les données du score depuis le backend
    fetch('score_data.php') 
        // Convertir la réponse en JSON
        .then(response => response.json())
        // Traiter les données JSON récupérées
        .then(data => {
            // Afficher les données du score dans la section appropriée
            // Supposons que le backend renvoie les scores sous forme de tableau
            const scores = data.scores;
            // Vérifier s'il y a des scores à afficher
            if (scores.length > 0) {
                // Générer le contenu HTML pour afficher les scores
                scoreSection.innerHTML = `
                    <h2>Votre Score</h2>
                    <ul>
                        ${scores.map(score => `<li>${score.date} - Score: ${score.points}</li>`).join('')}
                    </ul>
                `;
            } else {
                // Afficher un message s'il n'y a pas de score disponible
                scoreSection.innerHTML = '<p>Aucun score disponible pour le moment.</p>';
            }
        })
        // Gérer les erreurs éventuelles lors de la récupération des données
        .catch(error => {
            console.error('Une erreur s\'est produite lors de la récupération des scores:', error);
            // Afficher un message d'erreur dans la section de score
            scoreSection.innerHTML = '<p>Une erreur s\'est produite lors de la récupération des scores. Veuillez réessayer plus tard.</p>';
        });
});
