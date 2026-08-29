<?php

include "db.php";

// Total Doctors
$doctor_result = $conn->query("SELECT COUNT(*) AS total_doctors FROM doctors");
$doctor_count = $doctor_result->fetch_assoc()['total_doctors'];

// Total Patients
$patient_result = $conn->query("SELECT COUNT(*) AS total_patients FROM patients");
$patient_count = $patient_result->fetch_assoc()['total_patients'];

// Total Appointments
$appointment_result = $conn->query("SELECT COUNT(*) AS total_appointments FROM appointments");
$appointment_count = $appointment_result->fetch_assoc()['total_appointments'];

// Total Billing Amount
$billing_result = $conn->query("SELECT SUM(amount) AS total_billing FROM billing");
$billing_data = $billing_result->fetch_assoc();
$total_billing = $billing_data['total_billing'] ?? 0;

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <title>CareU Dashboard</title>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <style>

        body {
            margin: 0;
            font-family: Arial, Helvetica, sans-serif;
            background: #f4f7fc;
        }

        .sidebar {
            width: 220px;
            height: 100vh;
            background: #0077b6;
            color: white;
            display: flex;
            flex-direction: column;
            position: fixed;
            top: 0;
            left: 0;
        }

        .sidebar h1 {
            background-color: rgb(9, 65, 170);
            width: 220px;
            height: 100px;
            margin: 0;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .sidebar a {
            color: white;
            text-decoration: none;
            padding: 15px 20px;
            transition: background 0.3s;
        }

        .sidebar a:hover {
            background: #023e8a;
        }

        .main-content {
            margin-left: 220px;
            padding: 20px;
        }

        h2 {
            margin-top: 30px;
            color: #0077b6;
        }

        .stats {
            display: flex;
            gap: 20px;
            margin-top: 20px;
        }

        .card {
            flex: 1;
            background: white;
            padding: 20px;
            border-radius: 8px;
            text-align: center;
            font-weight: bold;
            color: #0077b6;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }

        .card-number {
            display: block;
            font-size: 28px;
            margin-top: 10px;
            color: #023e8a;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
            background: white;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }

        table th,
        table td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        table th {
            background: #0077b6;
            color: white;
        }

        table tr:hover {
            background: #f1f1f1;
        }

        .view-link {
            display: inline-block;
            margin-top: 10px;
            color: #0077b6;
            text-decoration: none;
            font-weight: bold;
        }

        .view-link:hover {
            text-decoration: underline;
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

    <p style="font-size: larger;">
        Welcome Back!
    </p>


    <div class="stats">

        <div class="card">

            👨‍⚕️ Doctors

            <span class="card-number">

                <?php echo $doctor_count; ?>

            </span>

        </div>


        <div class="card">

            🧑‍🤝‍🧑 Patients

            <span class="card-number">

                <?php echo $patient_count; ?>

            </span>

        </div>


        <div class="card">

            📅 Appointments

            <span class="card-number">

                <?php echo $appointment_count; ?>

            </span>

        </div>


        <div class="card">

            💰 Total Billing

            <span class="card-number">

                ₹<?php echo number_format($total_billing, 2); ?>

            </span>

        </div>

    </div>


    <h2>Recent Patients</h2>


    <table>

        <tr>

            <th>ID</th>

            <th>Name</th>

        </tr>


        <?php

        $patients = $conn->query(
            "SELECT patient_id, patient_name
             FROM patients
             ORDER BY patient_id DESC
             LIMIT 5"
        );


        if ($patients->num_rows > 0) {

            while ($row = $patients->fetch_assoc()) {

                echo "<tr>";

                echo "<td>" . $row['patient_id'] . "</td>";

                echo "<td>" . $row['patient_name'] . "</td>";

                echo "</tr>";

            }

        } else {

            echo "<tr>";

            echo "<td colspan='2'>
                    No patients found.
                  </td>";

            echo "</tr>";

        }

        ?>

    </table>


    <a class="view-link" href="Patient.php">

        View All Patients →

    </a>


    <h2>Recent Appointments</h2>


    <table>

        <tr>

            <th>Appointment ID</th>

            <th>Patient</th>

            <th>Doctor</th>

            <th>Date</th>

            <th>Status</th>

        </tr>


        <?php

        $appointments = $conn->query(

            "SELECT

                appointments.appointment_id,

                patients.patient_name,

                doctors.doctor_name,

                appointments.appointment_date,

                appointments.status

            FROM appointments

            INNER JOIN patients

            ON appointments.patient_id = patients.patient_id

            INNER JOIN doctors

            ON appointments.doctor_id = doctors.doctor_id

            ORDER BY appointments.appointment_id DESC

            LIMIT 5"

        );


        if ($appointments->num_rows > 0) {

            while ($row = $appointments->fetch_assoc()) {

                echo "<tr>";

                echo "<td>" .
                $row['appointment_id'] .
                "</td>";

                echo "<td>" .
                $row['patient_name'] .
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

        } else {

            echo "<tr>";

            echo "<td colspan='5'>

                    No appointments found.

                  </td>";

            echo "</tr>";

        }

        ?>

    </table>


    <a class="view-link" href="Appointment.php">

        View All Appointments →

    </a>


</div>

</body>

</html>