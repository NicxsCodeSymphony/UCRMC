<?php
// Include the Connection class file
include 'connection.php';

// Create a new instance of the Connection class
$newconnection = new Connection();

// Open a database connection
$pdo = $newconnection->openConnection();

// Initialize variables with default values
$studentID = $courseID = $subjectID = 0;

// Check if the request is a GET request and the required parameters are set
if ($_SERVER['REQUEST_METHOD'] == "GET" && isset($_GET['courseID'])) {
    $studentID = $_GET['studentID'];
    $courseID = $_GET['courseID'];
    $subjectID = $_GET['subjectID'];
}

if (isset($_GET['cta'])) {
    $prelim = $_GET['prelim'];
    $midterm = $_GET['midterm'];
    $semi = $_GET['semi-finals'];
    $finals = $_GET['finals'];

    $query = "INSERT INTO grade (studentID, courseID, subjectID, prelim, midterm, semifinal, final) VALUES (?, ?, ?,?,?,?,?)";
    try {
        // Prepare and execute the insertion query
        $stmt = $pdo->prepare($query);
        $stmt->execute([$studentID, $courseID, $subjectID, $prelim, $midterm, $semi, $finals]);

        // Check if the insertion was successful
        if ($stmt->rowCount() > 0) {
            // Redirect to teacherhome.php after successful insertion
            header('Location: teacherhome.php');
            exit();
        } else {
            echo "No rows were affected. Insertion may not have been successful.";
        }
    } catch (PDOException $e) {
        // Handle errors
        echo "Error: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Grade Input Form</title>
    <link href='https://fonts.googleapis.com/css?family=Rubik' rel='stylesheet'>

    <style>
        body {
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            margin: 0;
            font-family: 'Rubik', sans-serif;
        }

        form {
            text-align: center;
            max-width: 400px;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        label {
            display: block;
            margin-bottom: 10px;
            font-size: 16px;
        }

        input {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            box-sizing: border-box;
            font-size: 16px;
        }

        input[type="submit"] {
            background-color: #007BFF;
            color: #fff;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>

    <div>
        <h2 style="text-align: center;">Grade Input Form</h2>

        <form action="grade.php" method="get">
            <label for="prelim">Prelim Grade:</label>
            <input type="text" id="prelim" name="prelim" required>
            <br>

            <label for="midterm">Midterm Grade:</label>
            <input type="text" id="midterm" name="midterm" required>
            <br>

            <label for="semi-finals">Semi-Finals Grade:</label>
            <input type="text" id="semi-finals" name="semi-finals" required>
            <br>

            <label for="finals">Finals Grade:</label>
            <input type="text" id="finals" name="finals" required>
            <br>

            <input type="hidden" name="courseID" value="<?php echo $courseID; ?>">
            <input type="hidden" name="studentID" value="<?php echo $studentID; ?>">
            <input type="hidden" name="subjectID" value="<?php echo $subjectID; ?>">

            <input name="cta" type="submit" value="Submit Grades">
        </form>
    </div>

</body>
</html>
