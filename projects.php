<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Projects</title>
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
    </style>

</head>
<?php $page = 'projects'; require_once './header.php';
require_once "conn.php";
?>

<body>
    <div class="wrapper mt-4">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <?php
                    // DISPLAYING CONTENT
                    $sql = "SELECT Projects.id, project, group_concat(concat(firstname, ' ', lastname)SEPARATOR ', ') 
                    FROM Projects
                    LEFT JOIN Employees ON Projects.id = Employees.project_id
                    GROUP BY Projects.id;". (isset($_POST['id']) ? " WHERE id = ?" . $_POST['id'] : "");
                    if($result = mysqli_query($conn, $sql)){
                        if(mysqli_num_rows($result) > 0){
                            echo '<table class="table table-bordered table-striped">';
                                echo "<thead>";
                                    echo "<tr>";
                                        echo "<th>#</th>";
                                        echo "<th>Project</th>";
                                        echo "<th>Assigned employee</th>";
                                    echo "</tr>";
                                echo "</thead>";
                                echo "<tbody>";
                                while($row = mysqli_fetch_array($result)){
                                    echo "<tr>";
                                        echo "<td>" . $row['id'] . "</td>";
                                        echo "<td>" . $row['project'] . "</td>";
                                        echo "<td>" . $row["group_concat(concat(firstname, ' ', lastname)SEPARATOR ', ')"]. "</td>";
                                    echo "</tr>";
                                }
                                echo "</tbody>";                            
                            echo "</table>";
                            // Free result set
                            mysqli_free_result($result);
                        } else{
                            echo '<div class="alert alert-danger"><em>No records were found.</em></div>';
                        }
                    }
                    mysqli_close($conn);
                    ?>
                </div>
            </div>
        </div>
    </div>
    </div>
</body>

</html>