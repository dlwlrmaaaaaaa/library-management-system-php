<?php
    include('../dbconfig.php');
    include('includes/authenticate.php');

    $displaySuspendedUsers = "SELECT * FROM penalty";
    $stmt = $pdo->prepare($displaySuspendedUsers);
    $stmt->execute();
    $rows = $stmt->fetchAll(PDO::FETCH_OBJ);
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
         <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
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
                            <h2 class="fs-2 m-0 second-text">Suspended Users</h2>
                        </div>
                    </nav>

                    <div class="container-fluid px-4">
                        <form action="" method="post" class="post">
                            <br>
                            <div class="container col-md-11 maintop border border-dark">
                                <table class="table table-bordered-dark" id="tbl-borrowed-books">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Student Number</th>
                                            <th>Penalty Count</th>
                                            <th>Suspension</th>
                                            <th>Return Date</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                        <?php
                                        foreach($rows as $row){
                                            $id = $row->id;
                                            $student_number = $row->student_number;
                                            echo ' <tr>
                                                <th scope="row">' . $row->id . '</th>
                                                <td>' . $row->student_number . '</td>
                                                <td>' . $row->count. '</td>
                                                <td>' . $row->suspension . '</td> 
                                                <td>' . $row->penalty_deadline . '</td> 
                                                <td>
                                                    <a class="btn mx-auto" data-toggle="tooltip" title="Block User" onclick="blacklist(\'' . $id . '\', \'' . $student_number . '\')">
                                                        <i class="fa fa-ban mx-1"></i>
                                                    </a>
                                                    <a class="btn mx-auto" data-toggle="tooltip" title="Add Penalty Count" onclick="addCount(\'' . $id . '\', \'' . $student_number . '\')">
                                                        <i class="fa fa-plus mx-1"></i>
                                                    </a>
                                                </td> 
                                            </tr>';
                                        }
                                        ?>
                                    <tbody>

                                    </tbody>
                                </table>
                            </div>
                        </form>
                        <br>
                        <br>
                    </div>
                </div>
            </div>
        </div>
        <!-- /#page-content-wrapper -->
          <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
        

        <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
        <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
        <script > 
    
 var el = document.getElementById("wrapper");
 var toggleButton = document.getElementById("menu-toggle");

 
const blacklist = async (id, student_number) => {
  const confirmed = await swal({
    title: "Blacklisting",
    text: "When blacklisting was done, the users cannot login anymore.",
    icon: "info",
    buttons: ["No, cancel", "OK"],
    dangerMode: true,
  });

  if (confirmed) {
    try {
      const data = {
        id: id,
        student_number: student_number
      }
      const response = await fetch('expiredBooksAction/blacklist.php', {
        method: "POST",
        headers: { 'Content-type': 'application/json', },
        body: JSON.stringify(data),
      })
      if (!response.ok) {
        const errorMessage = await response.text();
        throw new Error(errorMessage || 'Network response was not okay');
      }
    } catch (error) {
      console.error("Error:", error.message);

      swal("Error", error.message, "error");
    }
        swal("Success", "Blacklisting done.", "success");
            setTimeout(() => {
                location.reload();
            }, 1500);
  } else {
    return;
  }
};
const addCount = async (id, student_number) => {
  const confirmed = await swal({
    title: "Confirmation",
    text: 'Click "OK" to Suspension',
    icon: "warning",
    buttons: ["No, cancel", "OK"],
    dangerMode: true,
  });
  if (confirmed) {
    const sendData = {
      id: id,
      student_number: student_number,
    };
    try {
      const response = await fetch("suspendAction/addCount.php", {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
        },
        body: JSON.stringify(sendData),
      });
      if (!response.ok) {
        throw new Error("Server response was not successful.");
      }
      swal("Success", "Applied Suspension", "success");
      setTimeout(() => {
        location.reload();
      }, 1500);
    } catch (error) {
      console.error(error);
    }
  } else {
    return;
  }
};


            toggleButton.onclick = function () {
            el.classList.toggle("toggled");
            };

            $(document).ready(function () {
            $("#tbl-borrowed-books").DataTable({});

            // Customizing the search bar
            $(".dataTables_filter input").addClass("form-control");
            $(".dataTables_filter input").attr("placeholder", "Search");
            $(".dataTables_filter label")
                .contents()
                .filter(function () {
                return this.nodeType === 3;
                })
                .remove();

            $(".dataTables_filter input").wrap('<div class="input-group"></div>');
            $(".dataTables_filter input").before(
                '<div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-search"></i></span></div>'
            );

            $(".dataTables_filter").addClass("col-6");
            });</script>
  
    </body>

    </html>