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
                        <h2 class="fs-2 m-0 second-text">Issue a Book</h2>
                    </div>
                </nav>

                <div class="container-fluid px-4">
                    <form action="" method="post" class="post">
                        <br>
                        <div class="container col-md-11 maintop border border-dark">
                            <table class="table table-bordered-dark" id="tbl-issue-book">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Student Number</th>
                                        <th>Book ID</th>
                                        <th>Book Name</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                            <?php
                            $student_number;
                            $book_id;
                            $title;
                              try {
                                $display = "SELECT * FROM borrowing";
                                $stmt = $pdo->prepare($display);
                                $stmt->execute();
                                $rows = $stmt->fetchAll(PDO::FETCH_OBJ);     
                                foreach($rows as $row)  {                  
                                    $student_number = $row->student_number;
                                    $user_id = $row->id;
                                    $book_id = $row->book_id;
                                    $title = $row->book_title;
                                    $borrow_id = $row->borrow_id;
                                    echo ' <tr>
                                        <th scope="row">' . $row->borrow_id . '</th>
                                        <td>' . $row->student_number  . '</td>
                                        <td>' . $row->book_id  . '</td>
                                        <td>' . $row->book_title . '</td>
                                        <td>
                                          <a class="btn mx-auto" data-toggle="tooltip" title="Accept" onclick="sendData(' . $user_id . ', \'' . $book_id . '\', \'' . $student_number . '\', \'' . $title  . '\', \'' . $borrow_id . '\')">
                                            <i class="fa fa-check mx-1" id="accept"></i>
                                        </a>
                                        <a href="#" class="btn mx-auto" data-toggle="tooltip" title="Deny" onclick="deleteData(' . $borrow_id . ')">
                                            <i class="fa fa-ban mx-1" name="ex"></i>
                                        </a>
                                        </td>
                                    </tr>';
                                    }  
                                }catch (Throwable $th) {
                                                        throw $th;
                                                    }

                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </form>
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
        
        const sendData = async (id, book_id, studentnumber , title, borrow_id) => {
           const confirmed = confirm('Click yes to issue book');
           if(confirmed){
             try {
                  const dataToSend = {
                        id: id,                     
                        book_id: book_id,
                        studentnumber: studentnumber,
                        title: title,
                        borrow_id: borrow_id,
                    };
                const response = await fetch('issued.php', {
                    method: 'POST',
                    headers: {
                        'Content-type': 'application/json',
                    },
                    body: JSON.stringify(dataToSend)
                });

                if (!response.ok) {
                    throw new Error('Network response was not ok.');
                }
                const data = await response.text();
                location.reload();
                console.log('Request Issued!'); 
            } catch (error) {
                console.error('Error:', error);
            }
           }
        };


        const deleteData = async (borrow_id) =>{
            const confirmed = confirm('Click ok to deny the request');
            const data = {
                borrow_id: borrow_id
            }

            if(confirmed){
                const response = await fetch('denied.php',  {
                    method: 'POST',
                    headers: {
                        'Content-type' : 'application/json',
                    },
                    body: JSON.stringify(data)
                })
                 if (!response.ok) {
                    throw new Error('Network response was not ok.');
                }

                const datos = await response.text()
                location.reload()
                console.log('Request Denied!');
            }
        }


        toggleButton.onclick = function () {
            el.classList.toggle("toggled");
        };

        $(document).ready(function() {
            $('#tbl-issue-book').DataTable({
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




?>