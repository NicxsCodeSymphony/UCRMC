<?php
session_start();
include 'connection.php';

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['departmentID'])) {
    $departmentID = $_GET['departmentID'];

    // Fetch the existing department data
    $conn = new Connection();
    $pdo = $conn->openConnection();

    $stmt = $pdo->prepare("SELECT * FROM department WHERE departmentID = ?");
    $stmt->execute([$departmentID]);
    $department = $stmt->fetch(PDO::FETCH_ASSOC);

    $conn->closeConnection();
} elseif ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['updateDepartment'])) {
    $departmentID = $_POST['departmentID'];
    $updateDepartmentName = $_POST['updateDepartmentName'];

    // Check if a new logo is being uploaded
    if (isset($_FILES['updateLogoInput']) && $_FILES['updateLogoInput']['error'] == 0) {
        // Handle image upload for update
        $updateImageURL = '';

        // Similar logic as in the existing code for image upload
        // ...

        // Update data with the new logo in the database
        $conn = new Connection();
        $pdo = $conn->openConnection();

        $stmt = $pdo->prepare("UPDATE department SET departmentName = ?, departmentLogo = ? WHERE departmentID = ?");
        $stmt->execute([$updateDepartmentName, $updateImageURL, $departmentID]);

        $conn->closeConnection();
    } else {
        // No new logo is uploaded, update only the department name
        $conn = new Connection();
        $pdo = $conn->openConnection();

        $stmt = $pdo->prepare("UPDATE department SET departmentName = ? WHERE departmentID = ?");
        $stmt->execute([$updateDepartmentName, $departmentID]);

        $conn->closeConnection();
    }

    // Redirect back to the main page or perform any other action
    header("Location: department.php");
    exit();
} else {
    // Invalid request, redirect to the main page or handle the error
    header("Location: department.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UCRMC | Update Department</title>
    <style>
        body {
            font-family: 'Rubik', sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            height: 100vh;
        }

        h1 {
            text-align: center;
            color: #333;
        }

        form {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 300px;
            margin: 0 auto;
        }

        label {
            display: block;
            margin-bottom: 8px;
        }

        input {
            width: 100%;
            padding: 8px;
            margin-bottom: 16px;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .add-logo-container {
            text-align: center;
        }

        .add-logo-button {
            display: inline-block;
            padding: 8px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .add-logo-preview {
            max-width: 100px;
            max-height: 100px;
            margin-top: 8px;
        }

        button {
            background-color: #007bff;
            color: #fff;
            border: none;
            padding: 10px 15px;
            border-radius: 4px;
            cursor: pointer;
        }
    </style>
</head>
<body>

    <h1>Update Department</h1>

    <form method="POST" action="update_department.php" enctype="multipart/form-data">
        <input type="hidden" name="departmentID" value="<?= $department['departmentID']; ?>">

        <!-- Add the file input for the image -->
        <div class="add-logo-container">
            <input type="file" name="updateLogoInput" id="updateLogoInput" accept="image/*" onchange="handleUpdateLogoInputChange()">
            <label for="updateLogoInput" class="add-logo-button">
                <img src="<?= $department['departmentLogo']; ?>" alt="Department Logo" class="add-logo-preview" id="updateLogoPreview">
            </label>
        </div>

        <label for="updateDepartmentName">Updated Department Name:</label>
        <input type="text" name="updateDepartmentName" value="<?= $department['departmentName']; ?>" required>

        <button type="submit" name="updateDepartment">Update</button>
    </form>

    <script>
        // Handle Logo Input Change for Update
        document.getElementById('updateLogoInput').addEventListener('change', handleUpdateLogoInputChange);

        function handleUpdateLogoInputChange() {
            const logoInput = document.getElementById('updateLogoInput');
            const updateLogoPreview = document.getElementById('updateLogoPreview');

            if (logoInput.files.length > 0) {
                const selectedImage = URL.createObjectURL(logoInput.files[0]);
                updateLogoPreview.src = selectedImage;
                updateLogoPreview.style.display = 'block'; // Show the image
            }
        }
    </script>

</body>
</html>
