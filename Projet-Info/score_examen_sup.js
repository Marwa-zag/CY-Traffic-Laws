document.addEventListener("DOMContentLoaded", function() {
    const scoreSection = document.getElementById('score-section');
    const canvas = document.createElement('canvas');
    canvas.id = 'scoreChart';
    scoreSection.appendChild(canvas);

    // Récupérer les données du score depuis le backend
    fetch('score_examen_sup_data.php') 
        .then(response => response.json())
        .then(data => {
            const scores = data.scores;
            if (scores.length > 0) {
                // Préparer les données pour le graphique
                const labels = scores.map(score => score.date);
                const points = scores.map(score => score.points);

                const scoresData = {
                    labels: labels,
                    datasets: [{
                        label: 'Scores',
                        data: points,
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 1
                    }]
                };

                const chartOptions = {
                    responsive: true,
                    maintainAspectRatio: false, 
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                };

                // Créer le graphique
                const ctx = document.getElementById('scoreChart').getContext('2d');
                new Chart(ctx, {
                    type: 'line', 
                    data: scoresData,
                    options: chartOptions
                });
            } else {
                scoreSection.innerHTML = '<p>Aucun score disponible pour le moment.</p>';
            }
        })
        .catch(error => {
            console.error('Une erreur s\'est produite lors de la récupération des scores:', error);
            scoreSection.innerHTML = '<p>Une erreur s\'est produite lors de la récupération des scores. Veuillez réessayer plus tard.</p>';
        });
});
