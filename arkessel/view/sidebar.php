<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="path/to/bootstrap.min.css" rel="stylesheet">
    <link href="path/to/font-awesome.min.css" rel="stylesheet">
        <link href="your-custom.css" rel="stylesheet">

    <style>
        .side-menu {
            width: 250px;
            height: 100%;
            position: fixed;
            top: 0;
            left: 0;
            background-color: #333;
            padding-top: 20px;
        }

        .side-menu a {
            padding: 10px 15px;
            text-decoration: none;
            font-size: 18px;
            color: #fff;
            display: block;
        }

        .side-menu a:hover {
            background-color: #555;
        }

        .content {
            margin-left: 260px;
            padding: 20px;
        }

    </style>
</head>
<body>
    <div class="side-menu">
        <a href="dashboard.php">
            <i class="fa fa-dashboard"></i> Dashboard
        </a>
        <a href="ticket.php">
            <i class="fa fa-ticket"></i> Event Management
        </a>
        <a href="admin.php">
            <i class="fa fa-user"></i> Admin
        </a>
        <a href="event.php">
            <i class="fa fa-book"></i> Events & Tickets
        </a>
        <a href="logout.php">
            <i class="fa fa-sign-out"></i> Logout
        </a>
    </div>

    <?php include_once "footer.php"; ?>

    <script src="path/to/bootstrap.min.js"></script>
</body>
</html>