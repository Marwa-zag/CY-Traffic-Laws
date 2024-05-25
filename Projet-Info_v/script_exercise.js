// Déclaration des variables globales
let currentQuestionIndex = 0;
let correctAnswers = 0;
let timer;

// Sélection des éléments HTML
const questionContainer = document.getElementById('question-container');
const questionElement = document.getElementById('question');
const optionsElement = document.getElementById('options');
const nextButton = document.getElementById('next-btn');
const scoreElement = document.getElementById('score');

// Fonction pour charger les questions depuis le fichier JSON
const loadQuestions = async () => {
    try {
        const response = await fetch('entrainement_questions.json');
        if (!response.ok) {
            throw new Error('Impossible de charger les questions.');
        }
        const data = await response.json();
        if (!data || data.length === 0) {
            throw new Error('Aucune question trouvée.');
        }
        window.questions = data;
        showQuestion();
    } catch (error) {
        console.error(error);
    }
};

// Fonction pour démarrer le compte à rebours
const startTimer = (timeLimit) => {
    let timeLeft = timeLimit;
    timer = setInterval(() => {
        const timerElement = document.getElementById('timer');
        if (timerElement) {
            timerElement.innerText = `Temps restant : ${timeLeft} s`;
        } else {
            console.error("L'élément avec l'ID 'timer' n'existe pas dans le DOM.");
        }
        if (timeLeft <= 0) {
            stopTimer();
            nextQuestion();
        }
        timeLeft--;
    }, 1000);
};

// Fonction pour afficher la question actuelle
const showQuestion = () => {
    const { question, imageSrc, options, timeLimit } = questions[currentQuestionIndex];
    
    // Affichage de la question et démarrage du timer
    questionElement.innerText = question;
    stopTimer();
    const timerElement = document.getElementById('timer');
    if (timerElement) {
        timerElement.innerText = '';
    }
    startTimer(timeLimit);

    // Affichage de l'image associée à la question
    const imageElement = document.createElement('img');
    imageElement.onload = () => {
        console.log('Image chargée avec succès');
    };
    imageElement.onerror = (error) => {
        console.error('Erreur lors du chargement de l\'image :', error);
    };
    imageElement.src = imageSrc;
    imageElement.alt = question;
    const imageContainer = document.getElementById('image-container');
    imageContainer.innerHTML = '';
    imageContainer.appendChild(imageElement);
    
    // Affichage des options de réponse
    optionsElement.innerHTML = '';
    options.forEach(option => {
        const button = document.createElement('button');
        button.innerText = option;
        button.classList.add('option-btn');
        button.addEventListener('click', () => selectOption(option));
        optionsElement.appendChild(button);
    });
};

// Fonction pour sélectionner une option de réponse
const selectOption = (selectedOption) => {
    const correctOption = questions[currentQuestionIndex].answer;
    stopTimer();
    if (selectedOption === correctOption) {
        console.log('Bonne réponse !');
        correctAnswers++;
    } else {
        console.log('Mauvaise réponse. La réponse correcte est :', correctOption);
    }
    nextQuestion();
};

// Fonction pour afficher le message de fin du quiz
const showMessage = () => {
    // Détermination du message en fonction du score obtenu
    let message = '';
    let imageSrc = '';

    if (correctAnswers < 10) {
        message = "Dommage, réessayez une autre fois. Allez voir les leçons disponibles sur le site pour vous améliorer.";
        imageSrc = "image-dommage.jpg";
    } else if (correctAnswers <= 15) {
        message = "Assez bien, continuez, vous êtes sur la bonne voie !";
        imageSrc = "image-assez-bien.jpg";
    } else if (correctAnswers < 22) {
        message = "Bravo, poursuivez vos efforts !";
        imageSrc = "image-bravo.jpg";
    } else {
        message = "Bravo ! Vous avez tout bon. Vous êtes prêt à passer l'examen blanc disponible sur le site.";
        imageSrc = "image-examen-blanc.jpg";
    }

    // Affichage du message avec le score obtenu et une image correspondante
    scoreElement.innerHTML = `<h2>${message}</h2><p>Score obtenu : ${correctAnswers} / ${questions.length}</p><img src="${imageSrc}" alt="${message}" />`;
    scoreElement.style.display = 'block';

    // Suppression de l'image associée à la question
    const imageContainer = document.getElementById('image-container');
    imageContainer.innerHTML = '';

    // Enregistrement du score
    saveScore(correctAnswers);
};

// Fonction pour enregistrer le score sur le serveur
const saveScore = (score) => {
    fetch('save_score.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: `score=${score}`
    })
    .then(response => {
        if (response.ok) {
            console.log('Score enregistré avec succès');
        } else {
            throw new Error('Erreur lors de l\'enregistrement du score');
        }
    })
    .catch(error => {
        console.error('Erreur:', error);
    });
};

// Fonction pour passer à la prochaine question
const nextQuestion = () => {
    // Réinitialisation du timer
    resetTimer();
    // Passage à la prochaine question
    currentQuestionIndex++;
    // Vérification s'il reste des questions à afficher
    if (currentQuestionIndex < questions.length) {
        // Affichage de la prochaine question
        showQuestion();
    } else {
        // Affichage du message de fin du quiz lorsque toutes les questions ont été répondues
        showMessage();
        // Effacement des éléments de question et d'options
        questionElement.innerHTML = '';
        optionsElement.innerHTML = '';
        // Masquage du bouton "Suivant"
        nextButton.style.display = 'none';
    }
};

// Écouteur d'événement sur le bouton "Suivant" pour passer à la prochaine question
nextButton.addEventListener('click', nextQuestion);

// Fonction pour arrêter le timer
const stopTimer = () => clearInterval(timer);

// Fonction pour réinitialiser le timer
const resetTimer = () => {
    const timerElement = document.getElementById('timer');
    if (timerElement) {
        timerElement.innerText = '';
    } else {
        console.error("L'élément avec l'ID 'timer' n'existe pas dans le DOM.");
    }
};

// Fonction exécutée lorsque la fenêtre est entièrement chargée
window.onload = loadQuestions;

// Écouteur d'événement pour charger les questions lorsque le DOM est chargé
document.addEventListener('DOMContentLoaded', () => {
    loadQuestions();
});
