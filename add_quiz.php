<!DOCTYPE html>
<html>
<head>
    <title>Add Quiz</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
<img src="logo2.png" alt="Quiz Logo" class="logo">
<h2>Add Quiz</h2>

<form action="add_quiz_process.php" method="post">
    Title <input type="text" name="title" required><br><br>
    Topic <input type="text" name="topic" required><br><br>

    <!-- Add questions and answers here -->
    <div id="questions">
        <div class="question">
            Question <input type="text" name="questions[0]" required><br><br>
            Answer 1 <input type="text" name="answers[0][0]" required>
            <input type="radio" name="correct_answers[0]" value="0" required> Correct<br><br><br>
            Answer 2 <input type="text" name="answers[0][1]" required>
            <input type="radio" name="correct_answers[0]" value="1" required> Correct<br><br><br>
            Answer 3 <input type="text" name="answers[0][2]" required>
            <input type="radio" name="correct_answers[0]" value="2" required> Correct<br><br><br>
        </div>
    </div>

    <button type="button" onclick="addQuestion()">Add Question</button><br>
    <input type="submit" value="Add Quiz" id="submit">
    <br>
    <br>
    <br>
</form>

<script>
    let questionCount = 1;

    function addQuestion() {
        questionCount++;

        let questionDiv = document.createElement('div');
        questionDiv.classList.add('question');
        questionDiv.innerHTML = `
            Question: <input type="text" name="questions[${questionCount}]" required><br><br>
            Answer 1: <input type="text" name="answers[${questionCount}][0]" required>
            <input type="radio" name="correct_answers[${questionCount}]" value="0" required> Correct<br>
            Answer 2: <input type="text" name="answers[${questionCount}][1]" required>
            <input type="radio" name="correct_answers[${questionCount}]" value="1" required> Correct<br>
            Answer 3: <input type="text" name="answers[${questionCount}][2]" required>
            <input type="radio" name="correct_answers[${questionCount}]" value="2" required> Correct<br><br>
        `;

        document.getElementById('questions').appendChild(questionDiv);
    }
</script>

</body>
</html>
