#  CareU – Hospital Management System

CareU is a PHP and MySQL-based Hospital Management System designed to manage essential hospital operations through a simple and user-friendly web interface.

##  Features

*  Patient Management
*  Doctor Management
*  Appointment Management
*  Problem / Symptoms Tracking
*  Billing Management
*  Department Management
*  Database relationships using foreign keys
*  Automatic bill generation for completed appointments
*  Dashboard for hospital information
*  Simple admin login

##  Technologies Used

* HTML
* CSS
* JavaScript
* PHP
* MySQL / MariaDB
* XAMPP
* phpMyAdmin

##  Database

The project uses a MySQL database named `careu_db`.

The database contains:

* `patients`
* `doctors`
* `departments`
* `appointments`
* `billing`
* `appointmentdetails` view

The SQL database backup is provided in:

`careu_db.sql`

##  How to Run

### 1. Install XAMPP

Install XAMPP with Apache and MySQL.

### 2. Copy the project

Copy the `careu` folder into:

`C:\xampp\htdocs\`

### 3. Start XAMPP

Start:

* Apache
* MySQL

### 4. Create the database

Open phpMyAdmin:

`http://localhost/phpmyadmin`

Create a database named:

`careu_db`

Import the provided:

`careu_db.sql`

### 5. Open the application

Open:

`http://localhost/careu/login.html`

###  Login

Username:

`admin`

Password:

`1234`

##  Project Structure

```text
careu/
│
├── dashboard.php
├── patient.php
├── doctor.php
├── appointment.php
├── billing.php
├── db.php
├── login.html
└── careu_db.sql
```

##  Project Objective

The objective of CareU is to provide a basic digital system for managing patients, doctors, appointments, departments, and billing information in a hospital environment.

##  Project

**CareU – Hospital Management System**
