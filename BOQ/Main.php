<?php
//    $conn = mysqli_connect("localhost", "root", "", "boq");?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js" integrity="sha256-oP6HI9z1XaZNBrJURtCoUT5SUnxFr8s3BzRl+cbzUq8=" crossorigin="anonymous"></script>
    <title>BOQ Table</title>
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            max-width: 1500px;
            margin: auto;
            padding: 20px;
        }
        @media (max-width: 768px) {
            .card h4, .card a.btn-primary {
                font-size: 1.1rem;
            }
        }

        @media (max-width: 576px) {
           #edit, #copy, #delete  {
                font-size: 13px;
                margin-bottom: 3px;
            }
        }


    </style>
</head>
<body>
<div class="container">
    <div class="card text-center" style="width: 100%; margin: auto">
        <div class="card-head text-center m-3" style="background-color:  #295F98">
            <h4 style="color: white; margin-top:15px">Manage BOQ</h4>
            <h4><a href="index.php" class="btn btn-primary">Create New BOQ</a></h4>
        </div>
        <div class="card-body">
            <!-- Make the table responsive by wrapping it in table-responsive -->
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead style="background-color: #295F98">
                    <tr class="text-center fw-bold">
                        <td style="background-color: #295F98; color:white;">Project Name</td>
                        <td style="background-color: #295F98; color:white;">Boq Title</td>
                        <td style="background-color: #295F98; color:white;">Date</td>
                        <td style="background-color: #295F98; color:white;">Action</td>
                    </tr>
                    </thead>
                    <tbody id="projectTableBody" class="text-center">
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function(){
            loadProject();
            function loadProject(){
                $.ajax({
                    type: "GET",
                    url: "loadProjects.php",
                    dataType: "JSON",
                    success: function(response){
                        if(response.success === true){
                            $("#projectTableBody").html(response.loadedHTML);
                        }
                    },
                    error: function (xhr, status, error) {
                        console.error('AJAX error:', status, error);
                    }
                });
            }
        });
    </script>
    <script src="jsfile.js"></script>
</div>
</body>
</html>
