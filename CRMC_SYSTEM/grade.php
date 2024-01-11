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

    // Check if grades already exist for the specified student and subject
    $checkQuery = "SELECT * FROM grade WHERE studentID = ? AND subjectID = ?";
    $checkStmt = $pdo->prepare($checkQuery);
    $checkStmt->execute([$studentID, $subjectID]);

    if ($checkStmt->rowCount() > 0) {
        // Grades already exist, display an alert
        echo "<script>alert('You have already added grades for this student and subject.');</script>";
        echo "<script>
            window.location.href = 'teacherhome.php'
        </script>";
        // You can redirect to another page or perform other actions as needed
    }
}

if (isset($_GET['cta'])) {
    $prelim = $_GET['prelim'];
    $midterm = $_GET['midterm'];
    $semi = $_GET['semi-finals'];
    $finals = $_GET['finals'];
    $average = $_GET['average'];
    $gwa = $_GET['gwa'];
    $remark = $_GET['remark'];

    $query = "INSERT INTO grade (studentID, courseID, subjectID, prelim, midterm, semifinal, final, total, gwa, remark) VALUES (?, ?, ?,?,?,?,?,?,?,?)";
    try {
        // Prepare and execute the insertion query
        $stmt = $pdo->prepare($query);
        $stmt->execute([$studentID, $courseID, $subjectID, $prelim, $midterm, $semi, $finals, $average, $gwa, $remark]);

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

            <input name="cta" onclick="updateAverageAndGWA();" type="submit" value="Submit Grades">



            <input type="hidden" name="average" id="average" readonly>
            <input type="hidden" name="gwa" id="gwa" readonly>
            <input type="hidden" name="remark" id="remark" readonly>
        </form>
    </div>

    <script>
        
        // Get references to the input fields
        const prelimInput = document.getElementById('prelim');
        const midtermInput = document.getElementById('midterm');
        const semiFinalsInput = document.getElementById('semi-finals');
        const finalsInput = document.getElementById('finals');
        const averageInput = document.getElementById('average');
        const gwaInput = document.getElementById('gwa');
        const remarkInput = document.getElementById('remark');

        // Event listener for input changes
        [prelimInput, midtermInput, semiFinalsInput, finalsInput].forEach(input => {
            input.addEventListener('input', updateAverageAndGWA);
        });

        // Function to update average and GWA
        function updateAverageAndGWA() {
            // Get the values from the input fields
            const prelim = parseFloat(prelimInput.value) || 0;
            const midterm = parseFloat(midtermInput.value) || 0;
            const semiFinals = parseFloat(semiFinalsInput.value) || 0;
            const finals = parseFloat(finalsInput.value) || 0;

            // Calculate the average
            const average = (prelim + midterm + semiFinals + finals) / 4;

            // Update the average input field
             averageInput.value = average.toFixed(2);

            // Calculate GWA based on the average
            const gwa = calculateGWA(average);
            gwaInput.value = gwa;

            // Update the remark input field
            remarkInput.value = determineRemark(average);            
        }

        // Function to calculate GWA based on average
        function calculateGWA(average) {
    if (average >= 98) {
        return 1.0;
    } else if (average >= 97) {
        return 1.1;
    } else if (average >= 95) {
        return 1.2;
    } else if (average >= 93) {
        return 1.3;
    } else if (average >= 91) {
        return 1.4;
    } else if (average >= 89) {
        return 1.5;
    } else if (average >= 87) {
        return 1.4;
    } else if (average >= 85) {
        return 1.5;
    } else if (average >= 83) {
        return 1.6;
    } else if (average >= 81) {
        return 1.7;
    } else if (average >= 79) {
        return 1.8;
    } else if (average >= 77) {
        return 1.9;
    } else if (average >= 75) {
        return 2.0;
    } else if (average >= 73) {
        return 2.1;
    } else if (average >= 71) {
        return 2.2;
    } else if (average >= 69) {
        return 2.3;
    } else if (average >= 67) {
        return 2.4;
    } else if (average >= 65) {
        return 2.5;
    } else if (average >= 63) {
        return 2.6;
    } else if (average >= 61) {
        return 2.7;
    } else if (average >= 59) {
        return 2.8;
    } else if (average >= 57) {
        return 2.9;
    }  else if (average >= 55) {
        return 3.0;
    } else if (average >= 53) {
        return 3.1;
    } else if (average >= 51) {
        return 3.2;
    } else if (average >= 49) {
        return 3.3;
    }

    // Add a default value if none of the conditions match
    return 0.0; // You can adjust the default value as needed
}

function determineRemark(average) {
            // Add conditions for determining the remark based on average
            // You can customize this based on your grading scale
            if (average >= 60) {
                return 'PASSED';
            }

            // Add a default value if none of the conditions match
            return 'FAILED';
        }

    </script>

</body>
</html>

</body>
</html>
