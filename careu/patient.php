<?php

include "db.php";

// ADD PATIENT
if (isset($_POST['add_patient'])) {

    $patient_id = $_POST['patient_id'];
    $patient_name = $_POST['patient_name'];
    $dob = $_POST['dob'];
    $gender = $_POST['gender'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];

    $sql = "INSERT INTO patients
            (patient_id, patient_name, dob, gender, phone, address)
            VALUES
            ('$patient_id', '$patient_name', '$dob', '$gender', '$phone', '$address')";

    if ($conn->query($sql) === TRUE) {
        echo "<script>
                alert('Patient added successfully!');
                window.location.href='Patient.php';
              </script>";
    } else {
        echo "Error: " . $conn->error;
    }
}

// DELETE PATIENT

if (isset($_GET['delete_id'])) {

    $patient_id = $_GET['delete_id'];

    // First delete appointments connected to this patient
    $sql1 = "DELETE FROM appointments
             WHERE patient_id = '$patient_id'";

    $conn->query($sql1);

    // Then delete the patient
    $sql2 = "DELETE FROM patients
             WHERE patient_id = '$patient_id'";

    if ($conn->query($sql2) === TRUE) {

        echo "<script>
                alert('Patient and related appointments deleted successfully!');
                window.location.href='Patient.php';
              </script>";

    } else {

        echo "Error: " . $conn->error;

    }
}

// UPDATE PATIENT
if (isset($_POST['update_patient'])) {

    $patient_id = $_POST['patient_id'];
    $patient_name = $_POST['patient_name'];
    $dob = $_POST['dob'];
    $gender = $_POST['gender'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];

    $sql = "UPDATE patients
            SET patient_name='$patient_name',
                dob='$dob',
                gender='$gender',
                phone='$phone',
                address='$address'
            WHERE patient_id='$patient_id'";

    if ($conn->query($sql) === TRUE) {
        echo "<script>
                alert('Patient updated successfully!');
                window.location.href='Patient.php';
              </script>";
    } else {
        echo "Error: " . $conn->error;
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Patients</title>
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

        table th, table td {
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

        .btn.edit {
            background:#2196f3;
            color:white;
        }

        .btn.delete {
            background:#f44336;
            color:white;
        }

        .btn:hover {
            opacity:0.8;
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

    <h2>Patient List</h2>

    <table id="patientTable">

        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Date of Birth</th>
            <th>Gender</th>
            <th>Phone</th>
            <th>Address</th>
            <th>Actions</th>
        </tr>

        <?php

        $sql = "SELECT * FROM patients";
        $result = $conn->query($sql);

        while ($row = $result->fetch_assoc()) {

            echo "<tr>";

            echo "<td>" . $row['patient_id'] . "</td>";
            echo "<td>" . $row['patient_name'] . "</td>";
            echo "<td>" . $row['dob'] . "</td>";
            echo "<td>" . $row['gender'] . "</td>";
            echo "<td>" . $row['phone'] . "</td>";
            echo "<td>" . $row['address'] . "</td>";

            echo "<td>

                <a href='Patient.php?edit_id=" . $row['patient_id'] . "'>
    <button class='btn edit'>Edit</button>
</a>

                <a href='Patient.php?delete_id=" . $row['patient_id'] . "'
                   onclick=\"return confirm('Are you sure you want to delete this patient?');\">

                    <button class='btn delete'>Delete</button>

                </a>

            </td>";

            echo "</tr>";
        }

        ?>

    </table>

    <?php

if (isset($_GET['edit_id'])) {

    $edit_id = $_GET['edit_id'];

    $sql = "SELECT * FROM patients
            WHERE patient_id='$edit_id'";

    $result = $conn->query($sql);

    $patient = $result->fetch_assoc();

?>

<h2>Edit Patient</h2>

<form method="POST">

    <input type="hidden"
           name="patient_id"
           value="<?php echo $patient['patient_id']; ?>">

    <label>Patient ID:</label>

    <input type="number"
           value="<?php echo $patient['patient_id']; ?>"
           readonly>

    <br><br>

    <label>Patient Name:</label>

    <input type="text"
           name="patient_name"
           value="<?php echo $patient['patient_name']; ?>"
           required>

    <br><br>

    <label>Date of Birth:</label>

    <input type="date"
           name="dob"
           value="<?php echo $patient['dob']; ?>"
           required>

    <br><br>

    <label>Gender:</label>

    <select name="gender">

        <option value="Male"
        <?php if ($patient['gender'] == 'Male') echo "selected"; ?>>
        Male
        </option>

        <option value="Female"
        <?php if ($patient['gender'] == 'Female') echo "selected"; ?>>
        Female
        </option>

        <option value="Other"
        <?php if ($patient['gender'] == 'Other') echo "selected"; ?>>
        Other
        </option>

    </select>

    <br><br>

    <label>Phone:</label>

    <input type="text"
           name="phone"
           value="<?php echo $patient['phone']; ?>"
           required>

    <br><br>

    <label>Address:</label>

    <input type="text"
           name="address"
           value="<?php echo $patient['address']; ?>"
           required>

    <br><br>

    <button type="submit"
            name="update_patient"
            class="btn edit">

        Update Patient

    </button>

</form>

<?php
}
?>

    <h2>Add New Patient</h2>

    <form method="POST">

        <label>Patient ID:</label>
        <input type="number" name="patient_id" required>

        <label>Patient Name:</label>
        <input type="text" name="patient_name" required>

        <label>Date of Birth:</label>
        <input type="date" name="dob" required>

        <label>Gender:</label>
        <select name="gender" required>
            <option value="">Select Gender</option>
            <option value="Male">Male</option>
            <option value="Female">Female</option>
            <option value="Other">Other</option>
        </select>

        <label>Phone:</label>
        <input type="text" name="phone" required>

        <br><br>

        <label>Address:</label>
        <input type="text" name="address" required>

        <br><br>

        <button type="submit" name="add_patient" class="btn add">
            Add Patient
        </button>

    </form>

</div>

</body>
<script>

function editRow(button) {

    let row = button.parentNode.parentNode;

    for (let i = 0; i < row.cells.length - 1; i++) {

        let currentValue = row.cells[i].innerText;

        let newValue = prompt(
            "Edit value:",
            currentValue
        );

        if (
            newValue !== null &&
            newValue.trim() !== ""
        ) {
            row.cells[i].innerText = newValue;
        }
    }
}

</script>
</html>