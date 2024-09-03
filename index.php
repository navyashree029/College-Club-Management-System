<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>College Club Management System</title>
    <?php require 'utils/styles.php'; ?>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .content {
            padding: 20px;
        }

        .index {
            max-width: 1000px;
            margin: 0 auto;
        }

        h1 {
            color: #004d99;
            font-size: 42px;
            font-weight: bold;
            text-align: center;
            margin-bottom: 30px;
        }

        .row {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            justify-content: center; /* Center align the items horizontally */
        }

        .col-md-6 {
            flex: 1;
            max-width: 50%;
        }

        .img-responsive {
            width: 100%;
            height: 300px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        .subcontent {
            padding: 20px;
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            text-align: center; /* Center align text within the subcontent */
        }

        .subcontent h1 {
            color: #004d99;
            font-size: 38px;
            margin-top: 0;
        }

        .subcontent p {
            font-size: 18px;
            line-height: 1.6;
        }

        .btn-tech {
            display: inline-block;
            padding: 10px 20px;
            font-size: 16px;
            text-align: center;
            border-radius: 5px;
            text-decoration: none;
            color: #ffffff;
            background: linear-gradient(45deg, #0056b3, #00aaff);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            transition: background 0.3s ease;
        }

        .btn-tech:hover {
            background: linear-gradient(45deg, #00aaff, #0056b3);
            text-decoration: none;
            color: #ffffff;
        }

        hr {
            border: 0;
            border-top: 2px solid #003300;
            margin: 20px 0;
        }
    </style>
</head>
<body>
    <?php require 'utils/header.php'; ?>

    <div class="content">
        <div class="index">
            <h1><strong>Register for your favourite events:</strong></h1>
        </div>

        <div class="container">
            <hr>
        </div>

        <div class="row">
            <section>
                <div class="container">
                    <div class="col-md-6">
                        <img src="images/technical.jpg" class="img-responsive" alt="Technical Events">
                    </div>
                    <div class="subcontent col-md-6">
                        <h1><u><strong>Technical Events</strong></u></h1>
                        <p>EMBRACE YOUR TECHNICAL SKILLS BY PARTICIPATING IN OUR DIFFERENT TECHNICAL EVENTS!</p>
                        <br><br>
                        <?php 
                        $id = 1;
                        echo '<a class="btn-tech" href="viewEvent.php?id=' . $id . '"> 
                                <span class="glyphicon glyphicon-circle-arrow-right"></span> View Technical Events
                              </a>';
                        ?>
                    </div>
                </div>
            </section>
        </div>

        <div class="container">
            <hr>
        </div>
    </div>

    <?php require 'utils/footer.php'; ?>
</body>
</html>
