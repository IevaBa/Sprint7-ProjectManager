<?php
require_once "conn.php";
 
$fname = $lname = $project ="";
$fname_err = $lname_err = $project_err = "";
 
if(isset($_POST["id"]) && !empty($_POST["id"])){
    $id = $_POST["id"];
    // Validate name
    $input_fname = trim($_POST["fname"]);
    if(empty($input_fname)){
        $fname_err = "Please enter a name.";
    } elseif(!filter_var($input_fname, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
        $fname_err = "Please enter a valid name.";
    } else{
        $fname = $input_fname;
    }
    // Validate surname
    $input_lname = trim($_POST["lname"]);
    if(empty($input_lname)){
        $lname_err = "Please enter a surname.";
    } elseif(!filter_var($input_lname, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
        $lname_err = "Please enter a valid surname.";
    } else{
        $lname = $input_lname;
    }
    // Project
    $input_project = trim($_POST["project"]);
    $project = $input_project;
    
    if(empty($fname_err) && empty($lname_err)){
        $sql = "UPDATE employees SET firstname=?, lastname=?, project_id=? WHERE id=?";
         
        if($stmt = mysqli_prepare($conn, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ssii", $param_fname, $param_lname, $param_project, $param_id);
            
            // Set parameters
            $param_fname = $fname;
            $param_lname = $lname;
            $param_project = $project;
            $param_id = $id;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Records updated successfully. Redirect to landing page
                header("location: index.php");
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
        
        $sql = "SELECT * FROM employees WHERE id = ?";
        if($stmt = mysqli_prepare($conn, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "i", $param_id);
            
            // Set parameters
            $param_id = $id;
            
            if(mysqli_stmt_execute($stmt)){
                $result = mysqli_stmt_get_result($stmt);
    
                if(mysqli_num_rows($result) == 1){
                    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
                    
                    $fname = $row["firstname"];
                    $lname = $row["lastname"];
                    $project = $row["project_id"];
                }          
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
        mysqli_stmt_close($stmt);      
    } 
}
// DROPDOWN
$sql = "SELECT DISTINCT * from Projects";
$res = mysqli_query($conn, $sql)
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
                    <p>Please edit the input values and submit to update the employee record.</p>
                    <form action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>" method="post">
                        <label>Name</label>
                        <input type="text" name="fname"
                            class="form-control <?php echo (!empty($fname_err)) ? 'is-invalid' : ''; ?>"
                            value="<?php echo $fname; ?>">
                        <span class="invalid-feedback"><?php echo $fname_err;?></span>
                        <label>Surname</label>
                        <input type="text" name="lname"
                            class="form-control <?php echo (!empty($lname_err)) ? 'is-invalid' : ''; ?>"
                            value="<?php echo $lname; ?>">
                        <span class="invalid-feedback"><?php echo $lname_err;?></span>
                        <select class="form-select form-select-lg my-2" aria-label=".form-select-lg example"
                            name="project">
                            <option selected>Choose project</option>
                            <?php while ( $rows = mysqli_fetch_array($res)) { ?>
                            <option value="<?php echo $rows['id'];  ?>"><?php echo $rows['project'];  ?>
                            </option>
                            <?php } ;?>
                        </select>
                        <input type="hidden" name="id" value="<?php echo $id; mysqli_close($conn)?>" />
                        <input type="submit" class="btn btn-primary mt-3" value="Submit">
                        <a href="projects.php" class="btn btn-secondary ml-2 mt-3">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>

</html>