<?php
require_once "conn.php";
 
$project ="";
$project_err = "";
 
if(isset($_POST["id"]) && !empty($_POST["id"])){
    $id = $_POST["id"];
    $input_project = trim($_POST["project"]);
    if(empty($input_project)){
        $project_err = "Please enter a project.";
    }else{
        $project = $input_project;
    }
    if(empty($project_err)){
        $sql = "UPDATE Projects SET project=? WHERE id=?";
         
        if($stmt = mysqli_prepare($conn, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "si", $param_project, $param_id);
            
            // Set parameters
            $param_project = $project;
            $param_id = $id;
            
            if(mysqli_stmt_execute($stmt)){
                header("location: projects.php");
                exit();
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
        mysqli_stmt_close($stmt);
    }
} else{
    if(isset($_GET["id"]) && !empty(trim($_GET["id"]))){
        $id =  trim($_GET["id"]);      
        $sql = "SELECT * FROM Projects WHERE id = ?";
        if($stmt = mysqli_prepare($conn, $sql)){
            mysqli_stmt_bind_param($stmt, "i", $param_id);        
            $param_id = $id;        
            if(mysqli_stmt_execute($stmt)){
                $result = mysqli_stmt_get_result($stmt); 
                if(mysqli_num_rows($result) == 1){
                    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
                    $project = $row["project"];                    
                } else{
                    header("location: error.php");
                    exit();
                }    
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
        mysqli_stmt_close($stmt);    
    } 
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Update Record</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
</head>

<body>
    <div class="wrapper mx-auto w-50">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="mt-5">Update Record</h2>
                    <p>Please edit the input value and submit to update the project record.</p>
                    <form action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>" method="post">
                        <div class="form-group">
                            <label class="my-2">Project</label>
                            <input type="text" name="project"
                                class="form-control <?php echo (!empty($project_err)) ? 'is-invalid' : ''; ?>"
                                value="<?php echo $row["project"]; ?>">
                            <span class="invalid-feedback"><?php echo $project_err;?></span>
                        </div>
                        <input type="hidden" name="id" value="<?php echo $id;  mysqli_close($conn);?>" />
                        <input type="submit" class="btn btn-primary mt-3" value="Submit">
                        <a href="projects.php" class="btn btn-secondary ml-2 mt-3">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>

</html>