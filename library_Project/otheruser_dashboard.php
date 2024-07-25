<?php

$userloginid=$_SESSION["userid"] = $_GET['userlogid'];
// echo $_SESSION["userid"];


?>


<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]>      <html class="no-js"> <![endif]-->
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Admin Dashboard</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
      <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
      <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <!-- <link rel="stylesheet" href="style.css"> -->
    </head>
    <style>
            .innerright,label {
    color: rgb(16, 170, 16);
    font-weight:bold;
}
.container,
.row,
.imglogo {
    margin:auto;
}

.innerdiv {
    text-align: center;
    /* width: 500px; */
    margin: 100px;
}
input{
    margin-left:20px;
}
.leftinnerdiv {
    float: left;
    width: 25%;
}

.rightinnerdiv {
    float: right;
    width: 75%;
}

.innerright {
    background-color: lightgreen;
}

.greenbtn {
    background-color: lightgray;
    color: black;
    width: 95%;
    height: 40px;
    margin-top: 8px;
}

.greenbtn,
a {
    text-decoration: none;
    color: black;
    font-size: large;
}

th{
    background-color: #16DE52;
    color: black;
}
td{
    background-color:#b1fec7;
    color: black;
}
td, a{
    color:black;
}
    </style>
    <body>

    <?php
// Start output buffering
ob_start();

// Initialize session
session_start();

// Include your data_class.php where your class and methods are defined
include("data_class.php");

// Retrieve user login ID from session or request
$userloginid = $_SESSION["userid"] = $_GET['userlogid'];

// Initialize your data class
$data = new data;
$data->setconnection(); // Ensure your setconnection method is correctly setting up the database connection

// HTML starts here
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
    <!-- Include necessary CSS and JavaScript files -->
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css">
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <style>
        /* Your custom styles */
    </style>
</head>
<body>
    <div class="container">
        <!-- Header or logo -->
        <div class="row">
            <img class="imglogo" src="images/Log.png" width="450px" height="90px"/>
        </div><br>

        <!-- Navigation buttons -->
        <div class="leftinnerdiv">
            <br>
            <button class="greenbtn" onclick="openpart('myaccount')"> <img class="icons" src="images/icon/profile.png" width="30px" height="30px"/>  My Account</button>
            <button class="greenbtn" onclick="openpart('requestbook')"><img class="icons" src="images/icon/book.png" width="30px" height="30px"/> Request Book</button>
            <button class="greenbtn" onclick="openpart('issuereport')"> <img class="icons" src="images/icon/monitoring.png" width="30px" height="30px"/>  Book Report</button>
            <a href="index.php"><button class="greenbtn"><img class="icons" src="images/icon/logout.png" width="30px" height="30px"/> LOGOUT</button></a>
        </div>

        <!-- Content area -->
        <div class="rightinnerdiv">
            <!-- My Account section -->
            <div id="myaccount" class="innerright portion">
                <button class="greenbtn">My Account</button>
                <?php
                // Retrieve user details
                $userData = $data->userdetail($userloginid);
                foreach($userData as $row) {
                    echo "<p><u>Person Name:</u> &nbsp&nbsp" . (isset($row['name']) ? $row['name'] : 'N/A') . "</p>";
                    echo "<p><u>Person Email:</u> &nbsp&nbsp" . (isset($row['email']) ? $row['email'] : 'N/A') . "</p>";
                    echo "<p><u>Account Type:</u> &nbsp&nbsp" . (isset($row['type']) ? $row['type'] : 'N/A') . "</p>";
                }
                ?>
            </div>

            <!-- Book Report section -->
            <div id="issuereport" class="innerright portion" style="display:none;">
                <button class="greenbtn">BOOK RECORD</button>
                <?php
                // Retrieve issued books data
                $issueData = $data->getissuebook($userloginid);
                if (!empty($issueData)) {
                    echo "<table style='font-family: Arial, Helvetica, sans-serif;border-collapse: collapse;width: 100%;'>";
                    echo "<tr><th>Name</th><th>Book Name</th><th>Issue Date</th><th>Return Date</th><th>Fine</th><th>Return</th></tr>";
                    foreach ($issueData as $row) {
                        echo "<tr>";
                        echo "<td>" . (isset($row['issuename']) ? $row['issuename'] : 'N/A') . "</td>";
                        echo "<td>" . (isset($row['issuebook']) ? $row['issuebook'] : 'N/A') . "</td>";
                        echo "<td>" . (isset($row['issuedate']) ? $row['issuedate'] : 'N/A') . "</td>";
                        echo "<td>" . (isset($row['issuereturn']) ? $row['issuereturn'] : 'N/A') . "</td>";
                        echo "<td>" . (isset($row['fine']) ? $row['fine'] : 'N/A') . "</td>";
                        echo "<td><a href='otheruser_dashboard.php?returnid=" . $row['id'] . "&userlogid=$userloginid'><button type='button' class='btn btn-primary'>Return</button></a></td>";
                        echo "</tr>";
                    }
                    echo "</table>";
                } else {
                    echo "<p>No issued books found.</p>";
                }
                ?>
            </div>

            <!-- Return Book section -->
            <div id="return" class="innerright portion" style="display:none;">
                <button class="greenbtn">Return Book</button>
                <?php
                if (!empty($_REQUEST['returnid'])) {
                    $returnid = $_REQUEST['returnid'];
                    $data->returnbook($returnid);
                }
                ?>
            </div>

            <!-- Request Book section -->
            <div id="requestbook" class="innerright portion" style="display:none;">
                <button class="greenbtn">Request Book</button>
                <?php
                // Retrieve available books data
                $bookData = $data->getbookissue();
                if (!empty($bookData)) {
                    echo "<table style='font-family: Arial, Helvetica, sans-serif;border-collapse: collapse;width: 100%;'>";
                    echo "<tr><th>Image</th><th>Book Name</th><th>Book Author</th><th>Branch</th><th>Price</th><th>Request Book</th></tr>";
                    foreach ($bookData as $row) {
                        echo "<tr>";
                        echo "<td><img src='uploads/" . (isset($row['bookpic']) ? $row['bookpic'] : '') . "' width='100px' height='100px' style='border:1px solid #333333;'></td>";
                        echo "<td>" . (isset($row['bookname']) ? $row['bookname'] : 'N/A') . "</td>";
                        echo "<td>" . (isset($row['bookaudor']) ? $row['bookaudor'] : 'N/A') . "</td>";
                        echo "<td>" . (isset($row['branch']) ? $row['branch'] : 'N/A') . "</td>";
                        echo "<td>" . (isset($row['bookprice']) ? $row['bookprice'] : 'N/A') . "</td>";
                        echo "<td><a href='requestbook.php?bookid=" . $row['id'] . "&userid=$userloginid'><button type='button' class='btn btn-primary'>Request Book</button></a></td>";
                        echo "</tr>";
                    }
                    echo "</table>";
                } else {
                    echo "<p>No books available for request.</p>";
                }
                ?>
            </div>
        </div>
    </div>

    <!-- JavaScript to handle switching between sections -->
    <script>
    function openpart(portion) {
        var x = document.getElementsByClassName("portion");
        for (var i = 0; i < x.length; i++) {
            x[i].style.display = "none";  
        }
        document.getElementById(portion).style.display = "block";  
    }
    </script>
</body>
</html>
<?php
// End of PHP script, flush output buffer
ob_end_flush();
?>
