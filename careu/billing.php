<?php

include "db.php";

// ADD BILL
if (isset($_POST['add_bill'])) {

    $bill_id = $_POST['bill_id'];
    $patient_id = $_POST['patient_id'];
    $amount = $_POST['amount'];
    $billing_date = $_POST['billing_date'];

    $sql = "INSERT INTO billing
            (bill_id, patient_id, amount, billing_date)
            VALUES
            ('$bill_id', '$patient_id', '$amount', '$billing_date')";

    if ($conn->query($sql) === TRUE) {

        echo "<script>
                alert('Billing record added successfully!');
                window.location.href='Billing.php';
              </script>";

        exit();

    } else {

        echo "Error: " . $conn->error;

    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <title>Billing</title>

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

        input {
            padding: 8px;
            margin: 5px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .btn {
            padding: 8px 14px;
            margin: 5px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 14px;
        }

        .btn.add {
            background: #4caf50;
            color: white;
        }

        .btn:hover {
            opacity: 0.8;
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

    <h2>Billing Records</h2>

    <table>

        <tr>
            <th>Bill ID</th>
            <th>Patient Name</th>
            <th>Amount</th>
            <th>Billing Date</th>
        </tr>

        <?php

        $sql = "SELECT
                    billing.bill_id,
                    patients.patient_name,
                    billing.amount,
                    billing.billing_date

                FROM billing

                INNER JOIN patients

                ON billing.patient_id = patients.patient_id

                ORDER BY billing.bill_id ASC";

        $result = $conn->query($sql);

        if ($result->num_rows > 0) {

            while ($row = $result->fetch_assoc()) {

                echo "<tr>";

                echo "<td>" . $row['bill_id'] . "</td>";

                echo "<td>" . $row['patient_name'] . "</td>";

                echo "<td>₹" . $row['amount'] . "</td>";

                echo "<td>" . $row['billing_date'] . "</td>";

                echo "</tr>";

            }

        } else {

            echo "<tr>";

            echo "<td colspan='4'>
                  No billing records found.
                  </td>";

            echo "</tr>";

        }

        ?>

    </table>


    <h2>Add New Billing Record</h2>

    <form method="POST">

        <label>Bill ID:</label>

        <input
        type="number"
        name="bill_id"
        required>


        <label>Patient ID:</label>

        <input
        type="number"
        name="patient_id"
        required>


        <label>Amount:</label>

        <input
        type="number"
        name="amount"
        step="0.01"
        required>


        <label>Billing Date:</label>

        <input
        type="date"
        name="billing_date"
        required>


        <br><br>


        <button
        type="submit"
        name="add_bill"
        class="btn add">

        Add Bill

        </button>

    </form>

</div>

</body>

</html>