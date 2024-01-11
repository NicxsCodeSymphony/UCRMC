<?php
include 'connection.php';
$conn = new Connection();
$pdo = $conn->openConnection();


if (isset($_GET['teacherName'])) {
    // Retrieve the value of the 'name' parameter
    $name = $_GET['teacherName'];
}

// Check if the 'age' parameter exists in the URL
if (isset($_GET['subjectName'])) {
    // Retrieve the value of the 'age' parameter
    $age = $_GET['subjectName'];
}

if (isset($_GET['subjectID'])) {
    // Retrieve the value of the 'age' parameter
    $subjectID = $_GET['subjectID'];
}

// Fetch all data based on subjectID, joining with the student table to get the full name
$stmt = $pdo->prepare("
    SELECT g.*, s.firstName, s.lastName
    FROM grade g
    INNER JOIN student s ON g.studentID = s.studentID
    WHERE g.subjectID = ?
");
$stmt->execute([$subjectID]);
$grades = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Display the grade sheet table
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Grade Sheet - <?php echo $age; ?></title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        a{
            color: #000;
            text-decoration: none;
        }

        a:visited{
            color: #000;
        }

        .container {
            text-align: center;
            /*border: 1px #000 solid;*/
            margin:  0 12%;
            padding: 15px 0;
            width: 65vw;
        }



        h1 {
            color: #333;
        }

        table {
            width: 87%;
            margin: 20px 30px;
            border-collapse: collapse;
            border: 1px solid #333;
        }

        th, td {
            padding: 12px;
            text-align: center;
            border: 1px solid #ddd;
        }

        th {
            background-color: #4CAF50;
            color: white;
        }

        tbody tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        p {
            text-align: center;
            color: #333;
        }

        .download-button {
            position: absolute;
            border-width: 0;
            color: white;
            font-size: 15px;
            font-weight: 600;
            border-radius: 4px;
            z-index: 1;
            top: 85%;
            left: 90%;
        }

        .download-button .docs {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 10px;
            min-height: 40px;
            padding: 0 10px;
            border-radius: 4px;
            z-index: 1;
            background-color: #242a35;
            border: solid 1px #e8e8e82d;
            transition: all .5s cubic-bezier(0.77, 0, 0.175, 1);
        }

        .download-button:hover {
            box-shadow: rgba(0, 0, 0, 0.25) 0px 54px 55px, rgba(0, 0, 0, 0.12) 0px -12px 30px, rgba(0, 0, 0, 0.12) 0px 4px 6px, rgba(0, 0, 0, 0.17) 0px 12px 13px, rgba(0, 0, 0, 0.09) 0px -3px 5px;
        }

        .download {
            position: absolute;
            inset: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            max-width: 90%;
            margin: 0 auto;
            z-index: -1;
            border-radius: 4px;
            transform: translateY(0%);
            background-color: #01e056;
            border: solid 1px #01e0572d;
            transition: all .5s cubic-bezier(0.77, 0, 0.175, 1);
        }

        .download-button:hover .download {
            transform: translateY(100%)
        }

        .download svg polyline, .download svg line {
            animation: docs 1s infinite;
        }

        @keyframes docs {
            0% {
                transform: translateY(0%);
            }

            50% {
                transform: translateY(-15%);
            }

            100% {
                transform: translateY(0%);
            }
        }
    </style>
</head>
<body>

    <a style="position: fixed; top: 10px; left: 30px;" href="teacherhome.php">&larr; Go back</a>

<div class="container">
    <h1>Grade Sheet - <?php echo $age;  ?></h1>


<?php if ($grades && count($grades) > 0): ?>
    <table>
        <thead>
        <tr>
            <th>Student Name</th>
            <th>Prelim</th>
            <th>Midterm</th>
            <th>Semifinal</th>
            <th>Final</th>
            <th>Total</th>
            <th>GWA</th>
            <th>Remark</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($grades as $grade): ?>
            <tr>
                <td><?php echo $grade['firstName'] . ' ' . $grade['lastName']; ?></td>
                <td><?php echo $grade['prelim']; ?></td>
                <td><?php echo $grade['midterm']; ?></td>
                <td><?php echo $grade['semifinal']; ?></td>
                <td><?php echo $grade['final']; ?></td>
                <td><?php echo $grade['total']; ?></td>
                <td><?php echo $grade['gwa']; ?></td>
                <td><?php echo $grade['remark']; ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
<?php else: ?>
    <p>No grades found for the specified subject.</p>
<?php endif; ?>



<p style="margin-right: 10%; font-style: italic; text-align: right;">Prepared by: <?php echo $name ?></p>
</div>
<button class="download-button" id="downloadListImage">
    <div class="docs"><svg class="css-i6dzq1" stroke-linejoin="round" stroke-linecap="round" fill="none"
                             stroke-width="2" stroke="currentColor" height="20" width="20" viewBox="0 0 24 24"><path
                d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline
                points="14 2 14 8 20 8"></polyline><line y2="13" x2="8" y1="13" x1="16"></line><line y2="17" x2="8"
                                                                                                      y1="17" x1="16"></line><polyline
                points="10 9 9 9 8 9"></polyline></svg> Docs</div>
    <div class="download">
        <svg class="css-i6dzq1" stroke-linejoin="round" stroke-linecap="round" fill="none" stroke-width="2"
             stroke="currentColor" height="24" width="24" viewBox="0 0 24 24"><path
                d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line
                y2="3" x2="12" y1="15" x1="12"></line></svg>
    </div>
</button>

<script src="https://html2canvas.hertzen.com/dist/html2canvas.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>

<script>
    document.getElementById('downloadListImage').addEventListener('click', function () {
        // Use html2canvas to capture the content of the table
        html2canvas(document.querySelector('.container')).then(canvas => {
            // Convert canvas to a data URL
            const imgData = canvas.toDataURL('image/png');

            // Initialize jsPDF
            const pdf = new window.jspdf.jsPDF();

            // Add an image to the PDF
            pdf.addImage(imgData, 'PNG', 0, 0);

            // Save the PDF file
            pdf.save('grade_sheet.pdf');

            window.location.href = "teacherhome.php";
        });
    });
</script>

</body>
</html>

