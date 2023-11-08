<?php
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "quiz_app";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$quizzes_sql = "SELECT * FROM quizzes";
$quizzes_result = $conn->query($quizzes_sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Quiz Selection</title>
<!-- Include Bootstrap CSS -->
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/css/bootstrap.min.css">
<style>

  @font-face {
  font-family: 'Avenir';
  src: url('../Fonts/AvenirLTStd-Roman.otf'); 
  } 

  body, html {
    margin: 0;
    padding: 0;
    background-color: #f4f7f6;
    font-family: 'Avenir', sans-serif;
  }

  .header {
    background-color: #085399;
    color: #fff;
    padding: 1rem;
    display: flex;
    align-items: center;
    font-family: 'Avenir', sans-serif;
  }

  .header img {
    height: 50px; /* Adjust based on your logo's aspect ratio */
  }

  .header .header-title {
    margin-left: 15px; /* Spacing between logo and title */
    font-size: 2rem;
  }

  .motivational-sentence {
    margin-top: 20vh;
    text-align: center;
    font-size: 1.5rem;
    color: #085399;
    font-weight: bold;
    text-shadow: 1px 1px 2px #adb5bd;
  }

  .container {
    padding: 2rem;
  }
  
  .quiz-grid {
    margin-top: 1vh;
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 1rem;
  }

  .quiz-card {
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    padding: 2rem;
    border-radius: 0.5rem;
    transition: transform 0.3s ease;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    height: 200px;
    background-color: #fff;
    font-family: 'Avenir', sans-serif;
  }
  .quiz-card:hover {
    transform: scale(1.05);
    box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
  }
  .quiz-title {
    font-size: 1.5rem;
    color: #085399;
    text-align: center;
    font-family: 'Avenir', sans-serif;
  }
</style>
</head>
<body>
  <header class="header">
    <img src="logo2.png" alt="Website Logo"> <!-- Replace 'logo.png' with your logo's filename -->
    <div class="header-title">BrainyBuzz</div>
  </header>
  <div class="motivational-sentence">
    Knowledge is power. Test yours today!
  </div>

  <div class="container">
    <div class="quiz-grid">
      <?php while ($row = $quizzes_result->fetch_assoc()): ?>
        <div class="quiz-card" onclick="location.href='take_quiz.php?quiz_id=<?php echo $row['id']; ?>';">
          <div class="quiz-title"><?php echo $row['title']; ?></div>
        </div>
      <?php endwhile; ?>
    </div>
  </div>

  <!-- Bootstrap Bundle with Popper -->
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/js/bootstrap.bundle.min.js"></script>
</body>