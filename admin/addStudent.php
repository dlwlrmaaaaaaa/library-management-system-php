<?php  
   include('../dbconfig.php');
   include('includes/authenticate.php');
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
            <?php include('includes/sidebar.php'); ?>
            <!-- Page Content -->
            <div id="page-content-wrapper" class="scrollable-content">
            
                <nav class="navbar navbar-expand-lg navbar-light bg-transparent py-4 px-4">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-align-left second-text fs-4 me-3" id="menu-toggle"></i>
                        <h2 class="fs-2 m-0 second-text">Manage Students</h2>
                    </div>
                </nav>

                <div class="container-fluid px-4">
                    <form action="" method="post" class="post">
                        <br>
                        <div class="container col-md-9 top border border-dark">
                            <div class="d-flex justify-content-between my-3">
                                <h3>Add a New Student</h3>
                                <div class="d-flex">
                                    <a href="manageStudent.php" class="btn btn-light"><i class="fa fa-list mx-1"></i> Student List</a>
                                </div>
                            </div>
                        </div>
                        <div class="container col-md-9 main border border-dark">
                            <div class="form-element mt-4">
                                <input type="text" class="form-control" name="name" placeholder="Name">
                            </div>
                            <div class="form-element mt-3">
                                <input type="text" class="form-control" name="studNum" placeholder="Student Number">
                            </div>
                            <div class="form-element mt-3">
                                <select name="course" class="form-control">
                                    <option value="" disabled selected>Select a Course</option>
                                    <option value="BSCS">BSCS</option>
                                    <option value="BSIS">BSIS</option>
                                    <option value="BSIT">BSIT</option>
                                    <option value="BSEMC">BSEMC</option>
                                </select>
                            </div>
                            <div class="form-element mt-3">
                                <input type="text" class="form-control" name="email" placeholder="Email Address">
                            </div>
                            <div class="form-element mt-3">
                                <input type="password" class="form-control" name="password" placeholder="Password">
                            </div>
                            <div class="form-element my-4">
                                <input type="submit" name="submit" value="submit" class="btn btn-secondary">
                            </div>
                        </div>
                    </form>
                    <br>
                </div>
            </div>
        </div>
    </div>
    <!-- /#page-content-wrapper -->
    
    <!-- Bootstrap CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
     <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
   

    <!-- Bootstrap JS (Popper.js and Bootstrap JS) -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <!-- jQuery -->
   



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
    if (isset($_POST['submit'])) {
        // Retrieve form data
        $name = htmlspecialchars($_POST['name']);
        $studNum = htmlspecialchars($_POST['studNum']);
        $course = isset($_POST['course']) ? htmlspecialchars($_POST['course']) : '';
        $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
        $password = $_POST['password'];
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Check if all input fields are empty
        if (empty($name) || empty($studNum) || empty($email) || empty($password)) {
            echo "<script> swal('Error!', 'Required fields are empty!', 'error'); </script>";
        } else {
            $existingStudentCheck = "SELECT student_number FROM students WHERE student_number = :studNum";
            $stmtCheck = $pdo->prepare($existingStudentCheck);
            $stmtCheck->execute([':studNum' => $studNum]);
            $existingStudent = $stmtCheck->fetchColumn();
            if ($existingStudent) {
                echo "<script> swal('Error!', 'Student number already exists.', 'warning'); </script>";
            } else {
                try {
                    $sql = "INSERT INTO students (full_name, student_number, course, email, password) VALUES (:name, :studNum, :course, :email, :password)";
                    $stmt = $pdo->prepare($sql);
                    $stmt->execute([
                        ":name" => $name,
                        ":studNum" => $studNum,
                        ":course" => $course,
                        ":email" => $email,
                        ":password" => $hashedPassword
                    ]);
                    if ($stmt->rowCount() > 0) {
                        echo "<script> swal('Success!', 'Student added successfully', 'success'); </script>";
                    } else {
                        echo "<script> swal('Error!', 'Failed to add student.', 'error'); </script>";
                    }
                } catch (PDOException $e) {
                    echo "<script> swal('Error!', 'Database error occurred.', 'error'); </script>";                 
                }
            }
        }
    }
} catch (Exception $e) {
    echo "<script>alert('" . $e->getMessage() . "')</script>";
}
?>