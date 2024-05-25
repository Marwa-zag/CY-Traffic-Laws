document.addEventListener("DOMContentLoaded", function() {
    const scoreSection = document.getElementById('score-section');

    // Récupérer les données du score depuis le backend
    fetch('score_examen_data.php') // Assure-toi d'ajuster le nom du fichier PHP selon ton backend
        .then(response => response.json())
        .then(data => {
            // Afficher les données du score dans la section appropriée
            const scores = data.scores; // Supposons que le backend renvoie les scores sous forme de tableau
            if (scores.length > 0) {
                scoreSection.innerHTML = `
                    <h2>Votre Score</h2>
                    <ul>
                        ${scores.map(score => `<li>${score.date} - Score: ${score.points}</li>`).join('')}
                    </ul>
                `;
            } else {
                scoreSection.innerHTML = '<p>Aucun score disponible pour le moment.</p>';
            }
        })
        .catch(error => {
            console.error('Une erreur s\'est produite lors de la récupération des scores:', error);
            scoreSection.innerHTML = '<p>Une erreur s\'est produite lors de la récupération des scores. Veuillez réessayer plus tard.</p>';
        });
});