<?php

include "db.php";

// ADD APPOINTMENT
if (isset($_POST['add_appointment'])) {

    $appointment_id = $_POST['appointment_id'];
    $patient_id = $_POST['patient_id'];
    $problem = $_POST['problem'];
    $doctor_id = $_POST['doctor_id'];
    $appointment_date = $_POST['appointment_date'];
    $status = $_POST['status'];

    $sql = "INSERT INTO appointments
            (appointment_id, patient_id, problem, doctor_id, appointment_date, status)
            VALUES
            ('$appointment_id', '$patient_id', '$problem',
             '$doctor_id', '$appointment_date', '$status')";

    if ($conn->query($sql) === TRUE) {

        echo "<script>
                alert('Appointment added successfully!');
                window.location.href='Appointment.php';
              </script>";

    } else {

        echo "Error: " . $conn->error;

    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <title>Appointments</title>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

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

<h2>Appointments</h2>


<table>

<tr>

<th>ID</th>

<th>Patient</th>

<th>Problem / Symptoms</th>

<th>Doctor</th>

<th>Date</th>

<th>Status</th>

</tr>


<?php

$sql = "SELECT

appointments.appointment_id,

patients.patient_name,

appointments.problem,

doctors.doctor_name,

appointments.appointment_date,

appointments.status

FROM appointments

JOIN patients

ON appointments.patient_id =
patients.patient_id

JOIN doctors

ON appointments.doctor_id =
doctors.doctor_id
ORDER BY appointments.appointment_id ASC";
$result = $conn->query($sql);


while ($row = $result->fetch_assoc()) {

echo "<tr>";

echo "<td>" .
$row['appointment_id'] .
"</td>";

echo "<td>" .
$row['patient_name'] .
"</td>";

echo "<td>" .
$row['problem'] .
"</td>";

echo "<td>" .
$row['doctor_name'] .
"</td>";

echo "<td>" .
$row['appointment_date'] .
"</td>";

echo "<td>" .
$row['status'] .
"</td>";

echo "</tr>";

}

?>

</table>


<h2>Add Appointment</h2>


<form method="POST">


<label>Appointment ID:</label>

<input
type="number"
name="appointment_id"
required>


<label>Patient:</label>

<select
name="patient_id"
required>

<option value="">
Select Patient
</option>


<?php

$patients =
$conn->query(
"SELECT * FROM patients"
);

while (
$patient =
$patients->fetch_assoc()
) {

echo "<option value='" .

$patient['patient_id'] .

"'>" .

$patient['patient_name'] .

"</option>";

}

?>

</select>


<label>Problem / Symptoms:</label>

<input
type="text"
name="problem"
required>


<br><br>


<label>Doctor:</label>

<select
name="doctor_id"
required>

<option value="">
Select Doctor
</option>


<?php

$doctors =
$conn->query(
"SELECT * FROM doctors"
);

while (
$doctor =
$doctors->fetch_assoc()
) {

echo "<option value='" .

$doctor['doctor_id'] .

"'>" .

$doctor['doctor_name'] .

"</option>";

}

?>

</select>


<label>Appointment Date:</label>

<input
type="date"
name="appointment_date"
required>


<label>Status:</label>

<select
name="status"
required>

<option value="">
Select Status
</option>

<option value="Scheduled">
Scheduled
</option>

<option value="Completed">
Completed
</option>

<option value="Cancelled">
Cancelled
</option>

</select>


<br><br>


<button
type="submit"
name="add_appointment"
class="btn add">

Add Appointment

</button>


</form>


</div>

</body>

</html>