
<!DOCTYPE html>
<html lang="en">


<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP Practical Exam
Paper C</title>
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="css/fontawesome-all.min.css">
    <link rel="stylesheet" type="text/css" href="css/iofrm-style.css">
    <link rel="stylesheet" type="text/css" href="css/iofrm-theme9.css">
</head>
<body>
    <div class="form-body">
        <div class="row">
            <div class="img-holder">
                <div class="bg"></div>
                <div class="info-holder">
                    <h3>Registration Form</h3>
                   
                    <img src="images/12.png" alt="">
                </div>
            </div>
            <div class="form-holder">
                <div class="form-content">
                    <div class="form-items">
                    
                        <div class="page-links">
                            <a href="login.php">Login</a><a href="register.php" class="active">Register</a>
                            
                        </div>
                          <form action="register_process.php" method="POST">
                             <input class="form-control" type="text" id="name" placeholder="Enter name" name="name" required>
                             <input class="form-control" type="email" id="email" placeholder="Enter email" name="email" required>
                             <input class="form-control" type="text" id="address" placeholder="Enter address" name="address" required>
                             <input class="form-control" type="text" id="contact_no" placeholder="Enter contact_no" name="contact_no" required>
                             <input class="form-control" type="date" id="dob" name="dob"  required>
                             <input class="form-control" type="password" id="password" placeholder="Enter password" name="password" required>
                            

                            <div class="form-button">
                                <button id="submit" type="submit" class="ibtn">Register</button>
                            </div>
                        </form>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
<script src="js/jquery.min.js"></script>
<script src="js/popper.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/main.js"></script>
</body>


</html>