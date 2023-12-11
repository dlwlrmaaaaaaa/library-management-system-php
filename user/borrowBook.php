<?php
    include('../dbconfig.php');
    include('includes/authenticate.php');
    $id = $_GET['id'];
    $title;
    $author;
    $genre;
    $isbn;
    $copies;
    $summary;
    try {
        $sql = "SELECT * FROM books WHERE book_id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([":id" => $id]);
        $row = $stmt->fetch(PDO::FETCH_OBJ);
        if($stmt->rowCount() > 0){
             $title = $row->title;
            $author = $row->author;
            $genre = $row->genre;
            $isbn = $row->ISBN;
            $copies = $row->copies;
            $summary = $row->summary;
        }
    } catch (\Throwable $th) {
        //throw $th;
    }

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
                        <h2 class="fs-2 m-0 second-text">Book Information</h2>
                    </div>
                </nav>

                <div class="container-fluid px-4">
                    <form action="" method="post" class="post">
                        <br>
                        <div class="container col-md-11 maintop border border-dark">
                        <br>
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
                                                <input type="text" class="form-control" name="title" placeholder="Book Title" value="<?php echo $title; ?>">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-element my-2">
                                        <div class="row">
                                            <div class="col-md-2 my-2">
                                                <h6>Author:</h6>
                                            </div>
                                            <div class="col-md-10">
                                        <input type="text" class="form-control" name="author" placeholder="Author" value="<?php echo $author; ?>">
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
                                                    <option value="Fiction" <?php if ($genre === 'Fiction') echo 'selected'; ?>>Fiction</option>
                                                    <option value="Romance" <?php if ($genre === 'Romance') echo 'selected'; ?>>Romance</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-element my-2">
                                        <div class="row">
                                            <div class="col-md-2 my-2">
                                                <h6>ISBN:</h6>
                                            </div>
                                            <div class="col-md-10">
                                                <input type="text" class="form-control" name="isbn" placeholder="ISBN" value="<?php echo $isbn; ?>">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-element my-2">
                                        <div class="row">
                                            <div class="col-md-2 my-2">
                                                <h6>Copies:</h6>
                                            </div>
                                            <div class="col-md-10">
                                                <input type="text" class="form-control" name="copies" placeholder="Copies" value="<?php echo $copies; ?>">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-element my-2">
                                        <div class="row">
                                            <div class="col-md-2 my-2">
                                                <h6>Summary:</h6>
                                            </div>
                                            <div class="col-md-10">
                                                <textarea class="form-control" name="message" rows="5" cols="60" placeholder="Book Summary" ><?php echo $summary; ?></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="form-element my-3">
                                    <input type="submit" class="btn btn-secondary rounded" name="borrow" value="Borrow Book">
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
    $student_number = $_SESSION['student_number'];
    $fullname = $_SESSION['student_name'];
    $user_id = $_SESSION['user_id'];
    if(isset($_POST['borrow'])){
        try {
            $borrow = "INSERT INTO borrowing (book_id, full_name , student_number, book_title, id) VALUES (:book_id, :fn, :sn, :title, :user_id)";
            $stmt = $pdo->prepare($borrow);
            $stmt->execute([":book_id" => $id, 
            ":fn" => $fullname,
            ":sn" => $student_number, 
            ":title" => $title,
             ":user_id" => $user_id]);
            if($stmt){
                echo "<script> alert('Request book success!')
                    window.location.href = 'allBooks.php'
                </script>";     
            }
        }catch (Throwable $th) {
            throw $th;
        }


    }
    

?>