@extends('layout.masteradmin')
@section('page', 'Halaman Addquiz')
@section('content')
<div id="quizForm">
    <!-- Questions will be added here dynamically -->
</div>
<button id="addQuestion">Add Question</button>
<button id="submitQuiz">Submit Quiz</button>
<script>
    let questionCount = 0;

    function addQuestion() {
        questionCount++;

        const questionTemplate = `
        <div class="question">
          <h4>Question ${questionCount}</h4>
          <input type="text" name="question${questionCount}" placeholder="Enter question">
          <label><input type="radio" name="answer${questionCount}" value="1"> Option 1</label>
          <label><input type="radio" name="answer${questionCount}" value="2"> Option 2</label>
          <label><input type="radio" name="answer${questionCount}" value="3"> Option 3</label>
          <label><input type="radio" name="answer${questionCount}" value="4"> Option 4</label>
          <button class="removeQuestion">Remove</button>
        </div>
      `;

        const questionElement = document.createElement('div');
        questionElement.classList.add('questionContainer');
        questionElement.innerHTML = questionTemplate;

        document.getElementById('quizForm').appendChild(questionElement);
    }

    function removeQuestion(event) {
        event.target.closest('.questionContainer').remove();
    }

    document.getElementById('addQuestion').addEventListener('click', addQuestion);

    document.getElementById('quizForm').addEventListener('click', function(event) {
        if (event.target.classList.contains('removeQuestion')) {
            removeQuestion(event);
        }
    });

    document.getElementById('submitQuiz').addEventListener('click', function() {
        const questions = document.querySelectorAll('.question');
        const quizData = [];

        questions.forEach((question) => {
            const questionText = question.querySelector('input[type="text"]').value;
            const answer = question.querySelector('input[type="radio"]:checked');
            const answerValue = answer ? answer.value : null;

            if (questionText && answerValue) {
                quizData.push({
                    question: questionText,
                    answer: answerValue,
                });
            }
        });

        // You can send quizData to the server using fetch or any appropriate method
        // For example, if using fetch:
        fetch('/submit-quiz', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    quizData
                }),
            })
            .then(response => {
                if (response.ok) {
                    // Quiz submitted successfully
                    console.log('Quiz submitted!');
                } else {
                    // Error occurred while submitting quiz
                    console.error('Error submitting quiz');
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
    });
</script>
@endsection
