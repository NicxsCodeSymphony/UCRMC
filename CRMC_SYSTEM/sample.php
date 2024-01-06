<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dropdown Selection</title>
</head>
<body>

<form>
    <select name="dropdown" id="dropdown">
        <option value="option1">Option 1</option>
        <option value="option2">Option 2</option>
        <option value="option3">Option 3</option>
    </select>
</form>

<?php
// Check if the selectedValue parameter is set in the URL
if (isset($_GET['selectedValue'])) {
    // Retrieve the selected value from the URL parameter
    $selectedValue = $_GET['selectedValue'];

    // You can now use $selectedValue as needed, for example, store it in a PHP variable
    $phpVariable = $selectedValue;

    // Perform any other server-side operations with $phpVariable
    // ...

    // Display the processed value
    echo '<p>Processed Value: ' . $phpVariable . '</p>';
} else {
    // Handle the case where selectedValue is not set
    echo 'Error: Selected value not received.';
}
?>

<script>
    document.getElementById('dropdown').addEventListener('change', function() {
        // Get the selected value
        var selectedValue = this.value;

        // Update the URL parameter with the selected value
        // window.location.href = 'sample.php?selectedValue=' + selectedValue;
        window.location.href = "assign.php?teacherID=<?= $teacherInfo['teacherID']; ?>"
    });
</script>

</body>
</html>


