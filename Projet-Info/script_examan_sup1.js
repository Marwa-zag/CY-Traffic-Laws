let currentQuestionIndex = 0;
let correctAnswers = 0;
let timer;
let selectedOptions = [];

const questionContainer = document.getElementById('question-container');
const optionsElement = document.getElementById('options');
const nextButton = document.getElementById('next-btn');
const scoreElement = document.getElementById('score');

const loadQuestions = async () => {
    try {
        const response = await fetch('examen_sup1_questions.json');
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
            checkAnswer();
        }
        timeLeft--;
    }, 1000);
};

const showQuestion = () => {
    const { imageSrc, options, timeLimit } = questions[currentQuestionIndex];
    
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
    const imageContainer = document.getElementById('image-container');
    imageContainer.innerHTML = '';
    imageContainer.appendChild(imageElement);
    
    optionsElement.innerHTML = '';
    selectedOptions = [];
    options.forEach(option => {
        const button = document.createElement('button');
        button.innerText = option;
        button.classList.add('option-btn');
        button.addEventListener('click', () => toggleOption(button, option));
        optionsElement.appendChild(button);
    });
};

const toggleOption = (button, option) => {
    if (selectedOptions.includes(option)) {
        selectedOptions = selectedOptions.filter(selected => selected !== option);
        button.classList.remove('selected');
    } else {
        selectedOptions.push(option);
        button.classList.add('selected');
    }
};

const checkAnswer = () => {
    const correctOption = questions[currentQuestionIndex].answer;
    stopTimer();
    
    if (Array.isArray(correctOption)) {
        const isCorrect = selectedOptions.length === correctOption.length &&
                          selectedOptions.every(option => correctOption.includes(option));
        
        if (isCorrect) {
            console.log('Bonne réponse !');
            correctAnswers++;
        } else {
            console.log('Mauvaise réponse. Les réponses correctes sont :', correctOption.join(', '));
        }
    } else {
        if (selectedOptions.length === 1 && selectedOptions[0] === correctOption) {
            console.log('Bonne réponse !');
            correctAnswers++;
        } else {
            console.log('Mauvaise réponse. La réponse correcte est :', correctOption);
        }
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

    saveScore(correctAnswers);
};

const saveScore = (score) => {
    fetch('save_score_examen_sup.php', {
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
        optionsElement.innerHTML = '';
        nextButton.style.display = 'none';
    }
};

nextButton.addEventListener('click', checkAnswer);

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
