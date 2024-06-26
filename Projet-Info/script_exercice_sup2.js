let currentQuestionIndex = 0;
let correctAnswers = 0;
let timer;

const questionContainer = document.getElementById('question-container');
const questionElement = document.getElementById('question');
const optionsElement = document.getElementById('options');
const nextButton = document.getElementById('next-btn');
const scoreElement = document.getElementById('score');

const loadQuestions = async () => {
    try {
        const response = await fetch('exercice_sup2_questions.json');
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
    stopTimer();
    const timerElement = document.getElementById('timer');
    if (timerElement) {
        timerElement.innerText = '';
    }
    startTimer(timeLimit);

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

    if (correctAnswers < 5) {
        message = "Dommage, réessayez une autre fois. Allez voir les leçons disponibles sur le site pour vous améliorer.";
        imageSrc = "Image/image-dommage.jpg";
    } else {
        message = "Bravo ! Vous avez tout bon. Vous êtes prêt à passer l'examen blanc disponible sur le site.";
        imageSrc = "Image/image-examen-blanc.jpg";
    }

    scoreElement.innerHTML = `<h2>${message}</h2><p>Score obtenu : ${correctAnswers} / ${questions.length}</p><img src="${imageSrc}" alt="${message}" />`;
    scoreElement.style.display = 'block';

    const imageContainer = document.getElementById('image-container');
    imageContainer.innerHTML = '';

    saveScore(correctAnswers);
};

const saveScore = (score) => {
    fetch('save_score_exercice_sup.php', {
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

const nextQuestion = () => {
    resetTimer();
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