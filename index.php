<?php
        session_start();
        include("dbconfig.php");  
          
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" >
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="includes/style.css">
    <link rel="stylesheet" href="Bootsrap\css\bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
    <title>Urban Reads</title>
</head>
<body>
    <div class="background-container">
        <svg class="svg-background" version="1.1" xmlns="http://www.w3.org/2000/svg" 
            xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="100%" height="100%" viewBox="0 0 1600 900" preserveAspectRatio="xMidYMax slice">
                <defs>
                    <linearGradient id="bg">
                        <stop offset="0%" style="stop-color:rgba(130, 158, 249, 0.06)"></stop>
                        <stop offset="50%" style="stop-color:rgba(76, 190, 255, 0.6)"></stop>
                        <stop offset="100%" style="stop-color:rgba(115, 209, 72, 0.2)"></stop>
                    </linearGradient>
                    <path id="wave" fill="url(#bg)" d="M-363.852,502.589c0,0,236.988-41.997,505.475,0
            s371.981,38.998,575.971,0s293.985-39.278,505.474,5.859s493.475,48.368,716.963-4.995v560.106H-363.852V502.589z" />
                </defs>
                <g>
                    <use xlink:href='#wave' opacity=".3">
                        <animateTransform
                attributeName="transform"
                attributeType="XML"
                type="translate"
                dur="10s"
                calcMode="spline"
                values="270 230; -334 180; 270 230"
                keyTimes="0; .5; 1"
                keySplines="0.42, 0, 0.58, 1.0;0.42, 0, 0.58, 1.0"
                repeatCount="indefinite" />
                    </use>
                    <use xlink:href='#wave' opacity=".6">
                        <animateTransform
                attributeName="transform"
                attributeType="XML"
                type="translate"
                dur="8s"
                calcMode="spline"
                values="-270 230;243 220;-270 230"
                keyTimes="0; .6; 1"
                keySplines="0.42, 0, 0.58, 1.0;0.42, 0, 0.58, 1.0"
                repeatCount="indefinite" />
                    </use>
                    <use xlink:href='#wave' opacty=".9">
                        <animateTransform
                attributeName="transform"
                attributeType="XML"
                type="translate"
                dur="6s"
                calcMode="spline"
                values="0 230;-140 200;0 230"
                keyTimes="0; .4; 1"
                keySplines="0.42, 0, 0.58, 1.0;0.42, 0, 0.58, 1.0"
                repeatCount="indefinite" />
                    </use>
                </g>
            </svg>

        <div class="d-flex" id="wrapper">
            <!-- Page Content -->
            <div id="page-content-wrapper" class="scrollable-content">
            
                <nav class="navbar navbar-expand-lg navbar-light bg-transparent py-4 px-4">
                    <div class="d-flex align-items-center">
                        <img src="includes/logo1.png" class="logoo-img me-2">
                        <h2 class="fs-2 m-0 mx-2 second-text">UrbanReads</h2>
                    </div>
                </nav>

                <div class="container-fluid px-4">
                    <form method="post" action=""class="post">
                        <br>
                        <br>
                        <br>
                        <div class="container col-md-4 maintop border border-dark">
                        <div class="input-box">
                        <br>
                        <br>
                        <header>Welcome Back!</header><br>
                            <div class="input-field">
                                <input type="text" class="input" name="studentNumber" id="studentNumber" required autocomplete="off">
                                <label for="studentNumber">Student Number</label>
                            </div>
                            <div class="input-field">
                                <input type="password" class="input" id="password1" name="password" required>
                                <label for="password1">Enter Password</label>
                            </div>
                            <div class="input-field">
                                <input type="submit" class="submit" value="Login" href="dashboard.php" name="login">
                            </div>
                        </div>
                    </form>
                    <br>
                    <br>
                </div>
            </div>
        </div>
    </div>
    <!-- /#page-content-wrapper -->
    
    <!-- Bootstrap CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap JS (Popper.js and Bootstrap JS) -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>


    <script>
        var el = document.getElementById("wrapper");
        var toggleButton = document.getElementById("menu-toggle");

        toggleButton.onclick = function () {
            el.classList.toggle("toggled");
        };
    </script>
</body>
</html>
<?php
    try {
        if(isset($_POST['login'])){
            $username = $_POST['studentNumber'];
            $password = $_POST['password'];
            
 
        if (!is_numeric($username)) {
                    $sql = "SELECT * FROM admin WHERE username = :username";
                    $stmt = $pdo->prepare($sql);
                    $stmt->execute(['username' => $username]);
                    $admin = $stmt->fetch(PDO::FETCH_OBJ);                  
            if ($stmt->rowCount() > 0) {
                if (password_verify($password, $admin->password)) {
                    $_SESSION['admin_name'] = $admin->admin_name;     
                    $_SESSION['loggedin'] = true;                  
                     echo '<script>window.location.href = "admin/dashboard.php";</script>';
                     exit();
                 
                } else {
                    echo "<script> alert('Admin not found') </script>";
                }
            } else {
                 echo "<script> alert('Admin not found') </script>";
            }
     }else{
            $loginsql = "SELECT * FROM students WHERE student_number = :username";
            $stmt = $pdo->prepare($loginsql);
            $stmt->execute([":username" => $username]);
            $users = $stmt->fetch(PDO::FETCH_OBJ);
            if ($stmt->rowCount() > 0 && password_verify($password, $users->password)) {
            $_SESSION['student_name'] = $users->full_name;
            $_SESSION['userloggedin'] = true;
            echo '<script>window.location.href = "user/home.php";</script>';
            exit();
            } else {
                echo "<script> alert('Invalid student number or password') </script>";
            }

     }
                                           
}
}catch(PDOException $e) {
        echo "<script> alert('" + $e->getMessage() + "') </script>" ;
    }


?>