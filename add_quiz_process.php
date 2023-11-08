<?php
// Establish database connection
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "quiz_app";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get user input from form
$title = $_POST['title'];
$topic = $_POST['topic'];

// Insert quiz into the database
$sql = $conn->prepare("INSERT INTO quizzes (title, topic) VALUES (?, ?)");
$sql->bind_param("ss", $title, $topic);

if ($sql->execute() === TRUE) {
    


// Get the ID of the newly inserted quiz
$quiz_id = $conn->insert_id;

// Process questions and answers
foreach ($_POST['questions'] as $index => $question_text) {
    $question_sql = $conn->prepare("INSERT INTO questions (quiz_id, text) VALUES (?, ?)");
    $question_sql->bind_param("is", $quiz_id, $question_text);

    if ($question_sql->execute() === TRUE) {
        // Get the ID of the newly inserted question
        $question_id = $conn->insert_id;

        // Process answers
        foreach ($_POST['answers'][$index] as $answer_index => $answer_text) {
            $is_correct = ($_POST['correct_answers'][$index] == $answer_index) ? 1 : 0;

            $answer_sql = $conn->prepare("INSERT INTO answers (question_id, text, is_correct) VALUES (?, ?, ?)");
            $answer_sql->bind_param("isi", $question_id, $answer_text, $is_correct);
          

            if (!$answer_sql->execute()) {
                echo "Error: " . $answer_sql->error;
            }
        }
    } else {
        echo "Error: " . $question_sql->error;
    }
    
}
} else {
    echo "Error: " . $sql->error;
}
  echo '<script>window.location.href = "dashboard.php";</script>'; // Redirect to dashboard
$conn->close();
?>
