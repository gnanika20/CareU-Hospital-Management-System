-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 29, 2026 at 12:39 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `careu_db`
--

-- --------------------------------------------------------

--
-- Stand-in structure for view `appointmentdetails`
-- (See below for the actual view)
--
CREATE TABLE `appointmentdetails` (
`appointment_id` int(11)
,`patient_name` varchar(100)
,`doctor_name` varchar(100)
,`appointment_date` date
,`status` varchar(20)
);

-- --------------------------------------------------------

--
-- Table structure for table `appointments`
--

CREATE TABLE `appointments` (
  `appointment_id` int(11) NOT NULL,
  `patient_id` int(11) DEFAULT NULL,
  `problem` varchar(255) DEFAULT NULL,
  `doctor_id` int(11) DEFAULT NULL,
  `appointment_date` date DEFAULT NULL,
  `status` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `appointments`
--

INSERT INTO `appointments` (`appointment_id`, `patient_id`, `problem`, `doctor_id`, `appointment_date`, `status`) VALUES
(401, 301, 'Fever and body pain', 201, '2026-07-20', 'Completed'),
(402, 302, 'Stomach pain', 202, '2026-07-21', 'Scheduled'),
(403, 303, 'Headache and dizziness', 203, '2026-07-22', 'Completed'),
(404, 304, 'Cough and cold', 204, '2026-07-23', 'Scheduled'),
(405, 305, 'Back pain', 205, '2026-07-24', 'Completed'),
(406, 301, 'Skin allergy', 202, '2026-07-30', 'Scheduled'),
(407, 302, 'Chest pain', 201, '2026-08-01', 'Completed');

--
-- Triggers `appointments`
--
DELIMITER $$
CREATE TRIGGER `GenerateBillAfterAppointment` AFTER INSERT ON `appointments` FOR EACH ROW BEGIN
    DECLARE new_bill_id INT;

    IF NEW.status = 'Completed' THEN

        SELECT IFNULL(MAX(bill_id),500)+1
        INTO new_bill_id
        FROM billing;

        INSERT INTO billing
        (bill_id,patient_id,amount,billing_date)
        VALUES
        (
            new_bill_id,
            NEW.patient_id,
            1500.00,
            NEW.appointment_date
        );

    END IF;

END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `billing`
--

CREATE TABLE `billing` (
  `bill_id` int(11) NOT NULL,
  `patient_id` int(11) DEFAULT NULL,
  `amount` decimal(10,2) DEFAULT NULL,
  `billing_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `billing`
--

INSERT INTO `billing` (`bill_id`, `patient_id`, `amount`, `billing_date`) VALUES
(501, 301, 1500.00, '2026-07-20'),
(502, 303, 2500.00, '2026-07-22'),
(503, 305, 1800.00, '2026-07-24'),
(504, 302, 1500.00, '2026-08-01'),
(505, 304, 2000.00, '2026-08-01'),
(506, 302, 1300.00, '2026-08-01');

-- --------------------------------------------------------

--
-- Table structure for table `departments`
--

CREATE TABLE `departments` (
  `department_id` int(11) NOT NULL,
  `department_name` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `departments`
--

INSERT INTO `departments` (`department_id`, `department_name`) VALUES
(101, 'Cardiology'),
(102, 'Neurology'),
(103, 'Orthopedics'),
(104, 'Pediatrics'),
(105, 'General Medicine'),
(106, 'Dermatology');

-- --------------------------------------------------------

--
-- Table structure for table `doctors`
--

CREATE TABLE `doctors` (
  `doctor_id` int(11) NOT NULL,
  `doctor_name` varchar(100) DEFAULT NULL,
  `specialization` varchar(100) DEFAULT NULL,
  `department_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `doctors`
--

INSERT INTO `doctors` (`doctor_id`, `doctor_name`, `specialization`, `department_id`) VALUES
(201, 'Dr.Meena', 'Cardiology', 101),
(202, 'Dr.Ravi', 'Neurology', 102),
(203, 'Dr.Priya', 'Orthopedics', 103),
(204, 'Dr.Arjun', 'Pediatrics', 104),
(205, 'Dr.Kavya', 'General Medicine', 105),
(206, 'Dr.Sam', 'Dermatology', 106),
(207, 'Dr.Neeharika', 'cardiology', 101);

-- --------------------------------------------------------

--
-- Table structure for table `patients`
--

CREATE TABLE `patients` (
  `patient_id` int(11) NOT NULL,
  `patient_name` varchar(100) DEFAULT NULL,
  `dob` date DEFAULT NULL,
  `gender` varchar(10) DEFAULT NULL,
  `phone` varchar(15) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `patients`
--

INSERT INTO `patients` (`patient_id`, `patient_name`, `dob`, `gender`, `phone`, `address`) VALUES
(301, 'Ramesh', '1995-06-12', 'Male', '9876543210', 'Hyderabad'),
(302, 'Sita', '2000-03-25', 'Female', '9123456780', 'Vijayawada'),
(303, 'Rahul', '1998-09-18', 'Male', '9988776655', 'Guntur'),
(304, 'Anjali', '2002-01-10', 'Female', '9012345678', 'Tenali'),
(305, 'Kiran', '1997-11-05', 'Male', '9090909093', 'Amaravati');

-- --------------------------------------------------------

--
-- Structure for view `appointmentdetails`
--
DROP TABLE IF EXISTS `appointmentdetails`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `appointmentdetails`  AS SELECT `a`.`appointment_id` AS `appointment_id`, `p`.`patient_name` AS `patient_name`, `d`.`doctor_name` AS `doctor_name`, `a`.`appointment_date` AS `appointment_date`, `a`.`status` AS `status` FROM ((`appointments` `a` join `patients` `p` on(`a`.`patient_id` = `p`.`patient_id`)) join `doctors` `d` on(`a`.`doctor_id` = `d`.`doctor_id`)) ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `appointments`
--
ALTER TABLE `appointments`
  ADD PRIMARY KEY (`appointment_id`),
  ADD KEY `patient_id` (`patient_id`),
  ADD KEY `doctor_id` (`doctor_id`);

--
-- Indexes for table `billing`
--
ALTER TABLE `billing`
  ADD PRIMARY KEY (`bill_id`),
  ADD KEY `patient_id` (`patient_id`);

--
-- Indexes for table `departments`
--
ALTER TABLE `departments`
  ADD PRIMARY KEY (`department_id`);

--
-- Indexes for table `doctors`
--
ALTER TABLE `doctors`
  ADD PRIMARY KEY (`doctor_id`),
  ADD KEY `department_id` (`department_id`);

--
-- Indexes for table `patients`
--
ALTER TABLE `patients`
  ADD PRIMARY KEY (`patient_id`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `appointments`
--
ALTER TABLE `appointments`
  ADD CONSTRAINT `appointments_ibfk_1` FOREIGN KEY (`patient_id`) REFERENCES `patients` (`patient_id`),
  ADD CONSTRAINT `appointments_ibfk_2` FOREIGN KEY (`doctor_id`) REFERENCES `doctors` (`doctor_id`);

--
-- Constraints for table `billing`
--
ALTER TABLE `billing`
  ADD CONSTRAINT `billing_ibfk_1` FOREIGN KEY (`patient_id`) REFERENCES `patients` (`patient_id`);

--
-- Constraints for table `doctors`
--
ALTER TABLE `doctors`
  ADD CONSTRAINT `doctors_ibfk_1` FOREIGN KEY (`department_id`) REFERENCES `departments` (`department_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
