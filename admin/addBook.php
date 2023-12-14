<?php
include('includes/authenticate.php');
include('../dbconfig.php');
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
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <!-- Include Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

    <!-- Include Bootstrap JS (including Popper.js) and jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
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
            <div id="page-content-wrapper" class="scrollable-content">
            
                <nav class="navbar navbar-expand-lg navbar-light bg-transparent py-4 px-4">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-align-left second-text fs-4 me-3" id="menu-toggle"></i>
                        <h2 class="fs-2 m-0 second-text">All Books</h2>
                    </div>
                </nav>

                <div class="container-fluid px-4">
                    <form action="" method="post" class="post" enctype="multipart/form-data">
                    <br>
                        <div class="container col-md-11 top border border-dark">
                            <div class="d-flex justify-content-between my-3">
                                <h3>Add New Book</h3>
                                <div class="d-flex">
                                    <a href="allBooks.php" class="btn btn-light"><i class="fa fa-list mx-1"></i> List of Books</a>
                                </div>
                            </div>
                        </div>
                        <div class="container col-md-11 main border border-dark">
                            <div class="row ">
                                <div class="col-md-3 my-2">
                                    <!-- Portrait Photo -->
                                    <img src="https://impressionsininkblog.files.wordpress.com/2021/08/6655.jpg" alt="Book Photo" class="img-fluid img-thumbnail" width="100">
                                </div>
                                <div class="col-md-9">
                                    <div class="form-element my-2">
                                        <div class="row">
                                            <div class="col-md-2 my-2">
                                                <h6>Book Title:</h6>
                                            </div>
                                            <div class="col-md-10">
                                                <input type="text" class="form-control" name="title" placeholder="Book Title">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-element my-2">
                                        <div class="row">
                                            <div class="col-md-2 my-2">
                                                <h6>Author:</h6>
                                            </div>
                                            <div class="col-md-10">
                                        <input type="text" class="form-control" name="author" placeholder="Author">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-element my-2">
                                        <div class="row">
                                            <div class="col-md-2 my-2">
                                                <h6>Genre:</h6>
                                            </div>
                                            <div class="col-md-10">
                                                <select name="genre" class="form-control">
                                                    <option value="" disabled selected>Select a Genre</option>
                                                    <option value="Fiction">Fiction</option>
                                                    <option value="Romance">Romance</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-element my-2">
                                        <div class="row">
                                            <div class="col-md-2 my-2">
                                                <h6>Copies:</h6>
                                            </div>
                                            <div class="col-md-10">
                                                <input type="text" class="form-control" name="copies" placeholder="Copies">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-element my-2">
                                        <div class="row">
                                            <div class="col-md-2 my-2">
                                                <h6>ISBN:</h6>
                                            </div>
                                            <div class="col-md-10">
                                                <input type="text" class="form-control" name="isbn" placeholder="ISBN">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-element my-2">
                                        <div class="row">
                                            <div class="col-md-2 my-2">
                                                <h6>Availability:</h6>
                                            </div>
                                            <div class="col-md-10">
                                                <textarea class="form-control" name="summary" rows="5" cols="60" placeholder="Enter a Summary"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="form-element my-3">
                                    <input type="file" class="btn btn-secondary rounded" name="upload" id="upload" value="Choose a Photo">
                                    <input type="submit" class="btn btn-secondary rounded" name="submit" value="Add Book">
                                </div>
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
    
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>


    <script>
        var el = document.getElementById("wrapper");
        var toggleButton = document.getElementById("menu-toggle");

        toggleButton.onclick = function () {
            el.classList.toggle("toggled");
        };

        $(document).ready(function() {
            $('#tbl-books').DataTable({
        });

            // Customizing the search bar
            $('.dataTables_filter input').addClass('form-control'); 
            $('.dataTables_filter input').attr('placeholder', 'Search');
            $('.dataTables_filter label').contents().filter(function() {
                return this.nodeType === 3; 
            }).remove(); 

            $('.dataTables_filter input').wrap('<div class="input-group"></div>');
            $('.dataTables_filter input').before('<div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-search"></i></span></div>');

            $('.dataTables_filter').addClass('col-6');
        });
    </script>
</body>

</html>
<?php

    
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    $title = $_POST['title'];
    $author = $_POST['author'];
    $copies = $_POST['copies'];
    $genre = $_POST['genre'];
    $isbn = $_POST['isbn'];
    $summary = $_POST['summary'];
    $targetDir = "upload/";
    
    $uploadOk = 1;
    $uniqid = uniqid();
    $randomPart = substr($uniqueID, 0, 6);
    $fileExtension = pathinfo($_FILES['upload']['name'], PATHINFO_EXTENSION);
    $randomFileName = $randomPart . '.' . $fileExtension;

    $destination = $targetDir . $randomFileName;
    $check = getimagesize($_FILES["upload"]["tmp_name"]);
    if ($check !== false) {
        $uploadOk = 1;
    } else {
        echo "File is not an image.";
        $uploadOk = 0;
    }
    if (file_exists($destination)) {
        echo "Sorry, file already exists.";
        $uploadOk = 0;
    }

    if ($_FILES["upload"]["size"] > 500000) {
        echo "Sorry, your file is too large.";
        $uploadOk = 0;
    }
    if (
        $fileExtension != "jpg" && $fileExtension != "png" && $fileExtension != "jpeg"
        && $fileExtension != "gif"
    ) {
        echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $uploadOk = 0;
    }
    if ($uploadOk == 1) {
        if (move_uploaded_file($_FILES["upload"]["tmp_name"], $destination)) {
            try {
                $sql = "INSERT INTO books (title, author, genre, ISBN, summary, copies, file_name) VALUES (:title, :author, :genre, :isbn, :summary, :copies, :filename)";
                $stmt = $pdo->prepare($sql);
                $stmt->execute([
                    ":title" => $title,
                    ":author" => $author,
                    ":genre" => $genre,
                    ":isbn" => $isbn,
                    ":summary" => $summary,
                    ":copies" => $copies,
                    ":filename" => $randomFileName
                ]);
            } catch (PDOException $th) {
                echo $th->getMessage();
            }
            
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }
}


?>