<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css"
        integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
    .wrapper {
        max-width: 80vw;
        margin: 0 auto;
    }

    table tr td:first-child {
        width: 3rem;
    }

    table tr td:last-child {
        width: 7rem;
    }
    </style>
</head>

<?php 
require_once "conn.php";
$page = 'home'; require_once './header.php';

// DELETE LOGIC
if(isset($_GET['action']) and $_GET['action'] == 'delete'){
$sql = 'DELETE FROM Employees WHERE id = ?';
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $_GET['id']);
$res = $stmt->execute();
$stmt->close();
mysqli_close($conn);
header("Location: " . strtok($_SERVER["REQUEST_URI"], '?'));
    die();
}
?>

<body>
    <div class="wrapper mt-4">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <?php
                    // DISPLAYING CONTENT 
                    $sql = "SELECT Employees.id, firstname, lastname, project 
                    FROM employees
                    LEFT JOIN Projects ON Employees.project_id = Projects.id ";
                    if($result = mysqli_query($conn, $sql)){
                        if(mysqli_num_rows($result) > 0){
                            echo '<table class="table table-bordered table-striped">';
                                echo "<thead>";
                                    echo "<tr>";
                                        echo "<th>#</th>";
                                        echo "<th>Name</th>";
                                        echo "<th>Surname</th>";
                                        echo "<th>Project</th>";
                                        echo "<th>Action</th>";
                                    echo "</tr>";
                                echo "</thead>";
                                echo "<tbody>";
                                while($row = mysqli_fetch_array($result)){
                                    echo "<tr>";
                                        echo "<td>" . $row['id'] . "</td>";
                                        echo "<td>" . $row['firstname'] . "</td>";
                                        echo "<td>" . $row['lastname'] . "</td>";
                                        echo "<td>" . $row['project'] . "</td>";
                                        echo "<td>";
                                            echo '<a href="update_employee.php?id='. $row['id'] .'" class="mx-3" title="Update Record" data-toggle="tooltip"><span class="fa fa-pencil"></span></a>';
                                            echo '<a href="?action=delete&id='. $row['id'] .'" title="Delete Record" data-toggle="tooltip"><span class="fa fa-trash mx-2"></span></a>';
                                        echo "</td>";
                                    echo "</tr>";
                                }
                                echo "</tbody>";                  
                            echo "</table>";
                            mysqli_free_result($result);
                        } else{
                            echo '<div class="alert alert-danger"><em>No records were found.</em></div>';
                        }
                    }
                    mysqli_close($conn);
                    ?>
                    <div class="mt-5 mb-3 clearfix">
                        <a href="create.php" class="btn btn-success pull-right"><i class="fa fa-plus"></i> Add New
                            Employee</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>