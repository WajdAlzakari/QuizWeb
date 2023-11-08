document.addEventListener('DOMContentLoaded', (event) => {
    const quizData = [
      {
        question: "What is the capital of France?",
        a: "London",
        b: "Paris",
        c: "Berlin",
        d: "Madrid",
        correct: "b",
      },
      {
        question: "Who is the CEO of Tesla?",
        a: "Jeff Bezos",
        b: "Elon Musk",
        c: "Bill Gates",
        d: "Steve Jobs",
        correct: "b",
      },
      // Add more questions as needed
    ];
  
    const quizContainer = document.getElementById('quiz');
    const resultContainer = document.getElementById('result');
    const submitButton = document.getElementById('submit');
  
    // Function to show questions
    function showQuestions(questions, quizContainer){
      const output = [];
      questions.forEach((currentQuestion, questionNumber) => {
        const answers = [];
        for(letter in currentQuestion){
          if(['question', 'correct'].includes(letter)) continue;
          answers.push(
            `<label>
              <input type="radio" name="question${questionNumber}" value="${letter}">
              ${letter}: ${currentQuestion[letter]}
            </label>`
          );
        }
        output.push(
          `<div class="question">
            <h2>Q${questionNumber + 1}: ${currentQuestion.question}</h2>
            <div class="options">${answers.join('')}</div>
          </div>`
        );
      });
      quizContainer.innerHTML = output.join('');
    }
  
    // Function to show results
    function showResults(questions, quizContainer, resultContainer){
      const answerContainers = quizContainer.querySelectorAll('.options');
      let correct = 0;
  
      questions.forEach((currentQuestion, questionNumber) => {
        const answerContainer = answerContainers[questionNumber];
        const selector = `input[name=question${questionNumber}]:checked`;
        const userAnswer = (answerContainer.querySelector(selector) || {}).value;
        if(userAnswer === currentQuestion.correct){
          correct++;
        }
      });
  
      resultContainer.innerHTML = `${correct} out of ${questions.length} correct`;
    }
  
    // Show the questions
    showQuestions(quizData, quizContainer);
  
    // On submit, show results
    submitButton.addEventListener('click', () => {
      showResults(quizData, quizContainer, resultContainer);
    });
  });