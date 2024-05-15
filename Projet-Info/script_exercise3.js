let currentQuestionIndex = 0;
let correctAnswers = 0;
let timer; // Variable globale pour stocker le chronomètre actuel

const questionContainer = document.getElementById('question-container');
const questionElement = document.getElementById('question');
const optionsElement = document.getElementById('options');
const nextButton = document.getElementById('next-btn');
const scoreElement = document.getElementById('score');

// Charger les questions via AJAX
const loadQuestions = async () => {
    try {
        const response = await fetch('entrainement3_questions.json');
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

const showQuestion = () => {
    const { question, imageSrc, options, timeLimit } = questions[currentQuestionIndex];
    
    questionElement.innerText = question;

    // Arrêter le chronomètre précédent s'il y en a un
    stopTimer();
    
    // Réinitialiser le texte du chronomètre à zéro
    const timerElement = document.getElementById('timer');
    if (timerElement) {
        timerElement.innerText = '';
    }
    
    // Démarrer le chronomètre pour la nouvelle question
    startTimer(timeLimit); // Utiliser le temps limite spécifié dans les données de la question

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
    
    optionsElement.innerHTML = '';
    options.forEach(option => {
        const button = document.createElement('button');
        button.innerText = option;
        button.classList.add('option-btn');
        button.addEventListener('click', () => selectOption(option));
        optionsElement.appendChild(button);
    });
};

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

const showMessage = () => {
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

    scoreElement.innerHTML = `<h2>${message}</h2><p>Score obtenu : ${correctAnswers} / ${questions.length}</p><img src="${imageSrc}" alt="${message}" />`;
    scoreElement.style.display = 'block';

    const imageContainer = document.getElementById('image-container');
    imageContainer.innerHTML = '';
};

const nextQuestion = () => {
    resetTimer(); // Arrêter le chronomètre actuel
    currentQuestionIndex++;
    if (currentQuestionIndex < questions.length) {
        showQuestion();
    } else {
        showMessage();
        questionElement.innerHTML = '';
        optionsElement.innerHTML = '';
        nextButton.style.display = 'none';
    }
};

nextButton.addEventListener('click', nextQuestion);

const stopTimer = () => clearInterval(timer);
const resetTimer = () => {
    const timerElement = document.getElementById('timer');
    if (timerElement) {
        timerElement.innerText = '';
    } else {
        console.error("L'élément avec l'ID 'timer' n'existe pas dans le DOM.");
    }
};

window.onload = loadQuestions;
document.addEventListener('DOMContentLoaded', () => {
    loadQuestions();
});
