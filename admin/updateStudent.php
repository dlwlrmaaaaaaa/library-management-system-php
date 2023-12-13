<?php
    include('../dbconfig.php');
    include('includes/authenticate.php');
    $id = $_GET['id'];

    $displaySelectedStudents = "SELECT * FROM students WHERE id = :id";
    $stmt = $pdo->prepare($displaySelectedStudents);
    $stmt->execute([':id' => $id]);
    $rows = $stmt->fetch(PDO::FETCH_OBJ);
    if($rows){
        $student_number = $rows->student_number;
        $fullname = $rows->full_name;
        $course = $rows->course;
        $email = $rows->email;
    }

    $student_number;
    $fullname;
    $course;
    $email;
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
                                    <h3>Update Student Information</h3>
                                    <div class="d-flex">
                                        <a href="manageStudent.php" class="btn btn-light"><i class="fa fa-list mx-1"></i> Student List</a>
                                    </div>
                                </div>
                           
                        </div>
                        <div class="container col-md-9 main border border-dark">
                            <div class="form-element mt-4">
                                <input type="text" class="form-control" name="name" placeholder="Name" value="<?php echo $fullname; ?>">
                            </div>
                            <div class="form-element mt-3">
                                <input type="text" class="form-control" name="studNum" placeholder="Student Number" value="<?php echo $student_number; ?>">
                            </div>
                            <div class="form-element mt-3">
                               <select name="course" class="form-control">
                                <option value="" disabled <?php echo ($course === '') ? 'selected' : ''; ?>>Select a Course</option>
                                <option value="BSCS" <?php echo ($course === 'BSCS') ? 'selected' : ''; ?>>BSCS</option>
                                <option value="BSIS" <?php echo ($course === 'BSIS') ? 'selected' : ''; ?>>BSIS</option>
                                <option value="BSIT" <?php echo ($course === 'BSIT') ? 'selected' : ''; ?>>BSIT</option>
                                <option value="BSEMC" <?php echo ($course === 'BSEMC') ? 'selected' : ''; ?>>BSEMC</option>
                            </select>
                            </div>
                            <div class="form-element mt-3">
                                <input type="text" class="form-control" name="email" placeholder="Email Address" value="<?php echo $email; ?>">
                            </div>
                            <div class="form-element mt-3">
                                <input type="text" class="form-control" name="password" placeholder="Password">
                            </div>
                            <div class="form-element my-4">
                                <input type="submit" class="btn btn-secondary" name="submit" value="Update">
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

    <!-- Bootstrap JS (Popper.js and Bootstrap JS) -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
     

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
    if(isset($_POST['submit'])){
        // Form validation
        if(!empty($_POST['studNum']) && !empty($_POST['name']) && !empty($_POST['email'])) {
            $studnum = $_POST['studNum'];
            $nameinput = $_POST['name'];
            $courseinput = $_POST['course'] ?? '';
            $emailinput = $_POST['email'];
            $newpassword = $_POST['password'];

            $hashedpassword = '';
            $updatesql = "UPDATE students SET student_number = :sn, full_name = :fn, course = :course, email = :email";
            
            if (!empty($newpassword)) {
                $hashedpassword = password_hash($newpassword, PASSWORD_DEFAULT);
                $updatesql .= ", password = :pass";
            }
            $updatesql .= " WHERE id = :id";          
            $stmt = $pdo->prepare($updatesql);
            $parameter = [":sn" => $studnum, ":fn" => $nameinput, ":course" => $courseinput, ":email" => $emailinput, ":id" => $id];           
            if (!empty($hashedpassword)) {
                $parameter[":pass"] = $hashedpassword;
            }     
            $rowAffected = $stmt->execute($parameter);

            if ($rowAffected) {            
                $student_number = $studnum;
                $fullname = $nameinput;
                $course = $courseinput;
                $email = $emailinput;    
                echo "<script> 
                        swal('Success!', 'Updated Succesfully!!', 'success'); 
                        setTimeout(function() {
                            window.location.href = 'manageStudent.php';
                        }, 2000); 
                    </script>";        
            }
            if(empty($_POST['studNum']) || empty($_POST['name']) || empty($_POST['course']) || empty($_POST['email']) || empty($_POST['password'])) {
                echo "<script> swal('Error!', 'Please fill in all Field Requirements!', 'error'); </script>";
            }
        }
    }
?>