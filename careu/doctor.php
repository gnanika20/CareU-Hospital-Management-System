<?php

include "db.php";

// ADD DOCTOR
if (isset($_POST['add_doctor'])) {

    $doctor_id = $_POST['doctor_id'];
    $doctor_name = $_POST['doctor_name'];
    $specialization = $_POST['specialization'];
    $department_id = $_POST['department_id'];

    $sql = "INSERT INTO doctors
            (doctor_id, doctor_name, specialization, department_id)
            VALUES
            ('$doctor_id', '$doctor_name', '$specialization', '$department_id')";

    if ($conn->query($sql) === TRUE) {

        echo "<script>
                alert('Doctor added successfully!');
                window.location.href='Doctor.php';
              </script>";

    } else {

        echo "Error: " . $conn->error;

    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <title>Doctors</title>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <style>

        body {
            margin:0;
            font-family:Arial,Helvetica,sans-serif;
            background:#f4f7fc;
        }

        .sidebar {
            width:220px;
            height:100vh;
            background:#0077b6;
            color:white;
            display:flex;
            flex-direction:column;
            position:fixed;
            top:0;
            left:0;
        }

        .sidebar h1 {
            background-color:rgb(9,65,170);
            width:220px;
            height:100px;
            margin:0;
            display:flex;
            align-items:center;
            justify-content:center;
        }

        .sidebar a {
            color:white;
            text-decoration:none;
            padding:15px 20px;
            transition:background 0.3s;
        }

        .sidebar a:hover {
            background:#023e8a;
        }

        .main-content {
            margin-left:220px;
            padding:20px;
        }

        h2 {
            margin-top:30px;
            color:#0077b6;
        }

        table {
            width:100%;
            border-collapse:collapse;
            margin-top:10px;
            background:white;
            box-shadow:0 2px 5px rgba(0,0,0,0.1);
        }

        table th,
        table td {
            padding:12px;
            text-align:left;
            border-bottom:1px solid #ddd;
        }

        table th {
            background:#0077b6;
            color:white;
        }

        table tr:hover {
            background:#f1f1f1;
        }

        .btn {
            padding:6px 12px;
            margin:2px;
            border:none;
            border-radius:4px;
            cursor:pointer;
            font-size:14px;
        }

        .btn.add {
            background:#4caf50;
            color:white;
        }

        .btn:hover {
            opacity:0.8;
        }

        input,
        select {
            padding:8px;
            margin:5px;
        }

    </style>

</head>

<body>

<div class="sidebar">

    <h1>🏥 CareU</h1>

    <a href="Dashboard.php">Dashboard</a>

    <a href="Patient.php">Patients</a>

    <a href="Doctor.php">Doctors</a>

    <a href="Appointment.php">Appointments</a>

    <a href="Billing.php">Billing</a>

    <a href="loginn.html">Logout</a>

</div>


<div class="main-content">

<h2>Doctor List</h2>


<table>

<tr>

    <th>ID</th>

    <th>Name</th>

    <th>Specialization</th>

    <th>Department ID</th>

</tr>


<?php

$sql = "SELECT * FROM doctors
        ORDER BY doctor_id ASC";

$result = $conn->query($sql);


while ($row = $result->fetch_assoc()) {

    echo "<tr>";

    echo "<td>" . $row['doctor_id'] . "</td>";

    echo "<td>" . $row['doctor_name'] . "</td>";

    echo "<td>" . $row['specialization'] . "</td>";

    echo "<td>" . $row['department_id'] . "</td>";

    echo "</tr>";

}

?>

</table>


<h2>Add New Doctor</h2>


<form method="POST">

    <label>Doctor ID:</label>

    <input
    type="number"
    name="doctor_id"
    required>


    <label>Doctor Name:</label>

    <input
    type="text"
    name="doctor_name"
    required>


    <label>Specialization:</label>

    <input
    type="text"
    name="specialization"
    required>


    <label>Department ID:</label>

    <input
    type="number"
    name="department_id"
    required>


    <br><br>


    <button
    type="submit"
    name="add_doctor"
    class="btn add">

    Add Doctor

    </button>

</form>


</div>

</body>

</html>