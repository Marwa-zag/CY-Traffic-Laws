// Définir les questions et les réponses
const questions = [
    {
        question: "Que signifie ce panneau ?",
        videoSrc: "video1.mp4",
        options: ["A. Cédez le passage", "B. Priorité à droite", "C. Arrêt obligatoire"],
        answer: "C. Arrêt obligatoire"
    },
    {
        question: "Quelle est la vitesse maximale autorisée sur autoroute ?",
        videoSrc: "video2.mp4",
        options: ["A. 90 km/h", "B. 110 km/h", "C. 130 km/h"],
        answer: "C. 130 km/h"
    },
    // Ajoute d'autres questions ici
];

// Initialisation des variables
let currentQuestionIndex = 0;

// Sélection des éléments du DOM
const questionContainer = document.getElementById('question-container');
const questionElement = document.getElementById('question');
const optionsElement = document.getElementById('options');
const nextButton = document.getElementById('next-btn');

// Afficher la première question
showQuestion();

// Affiche la question courante
function showQuestion() {
    const currentQuestion = questions[currentQuestionIndex];
    questionElement.innerText = currentQuestion.question;
    
    // Affiche la vidéo
    const videoElement = document.createElement('video');
    videoElement.src = currentQuestion.videoSrc;
    questionContainer.appendChild(videoElement);

    // Affiche les options
    optionsElement.innerHTML = '';
    currentQuestion.options.forEach(option => {
        const button = document.createElement('button');
        button.innerText = option;
        button.classList.add('option-btn');
        button.addEventListener('click', () => selectOption(option));
        optionsElement.appendChild(button);
    });
}

// Sélectionne une option
function selectOption(selectedOption) {
    const currentQuestion = questions[currentQuestionIndex];
    const correctOption = currentQuestion.answer;

    if (selectedOption === correctOption) {
        // Logique pour la réponse correcte
        console.log('Bonne réponse !');
    } else {
        // Logique pour la réponse incorrecte
        console.log('Mauvaise réponse. La réponse correcte est :', correctOption);
    }

    // Passer à la prochaine question
    nextQuestion();
}

// Passer à la prochaine question
function nextQuestion() {
    currentQuestionIndex++;
    if (currentQuestionIndex < questions.length) {
        // Afficher la prochaine question
        showQuestion();
    } else {
        // Fin de l'entraînement
        questionElement.innerText = 'Bravo ! Vous avez terminé l\'entraînement.';
        optionsElement.innerHTML = '';
        nextButton.disabled = true;
    }
}

// Gérer le clic sur le bouton "Question suivante"
nextButton.addEventListener('click', nextQuestion);
