<?php
require_once "conn.php";
 
$fname = $lname = $project = "";
$fname_err = $lname_err =  $project_err ="";
 
if($_SERVER["REQUEST_METHOD"] == "POST"){
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
    };
    // Project
    $input_project = trim($_POST["project"]);
    $project = $input_project === '' ? NULL : $input_project;

    // Check input errors before inserting in database
    if(empty($fname_err) && empty($lname_err)){
        $sql = "INSERT INTO Employees (firstname, lastname, project_id) VALUES (?, ?, ?)";
        
        if($stmt = mysqli_prepare($conn, $sql)){
            // Bind variables to the prepared statement as parameters
            $test = mysqli_stmt_bind_param($stmt, "ssd", $param_fname, $param_lname, $param_project);

            // Set parameters
            $param_fname = $fname;
            $param_lname = $lname;
            $param_project = $project;

            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Records created successfully. Redirect to landing page
                    header("location: index.php");
                exit();
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
    <title>Create Record</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
</head>

<body>
    <div class="wrapper w-50 mx-auto">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="mt-5">Create Record</h2>
                    <p>Please fill this form and submit to add employee record to the database.</p>
                    <?php
                    // DROPDOWN
                    $sql = "SELECT DISTINCT * from Projects";
                    $res = mysqli_query($conn, $sql)
                    ?>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div class="form-group">
                            <label class="my-2">Name</label>
                            <input type="text" name="fname"
                                class="form-control <?php echo (!empty($fname_err)) ? 'is-invalid' : ''; ?>"
                                value="<?php echo $fname; ?>">
                            <span class="invalid-feedback"><?php echo $fname_err;?></span>
                        </div>
                        <div class="form-group">
                            <label class="my-2">Surname</label>
                            <input type="text" name="lname"
                                class="form-control <?php echo (!empty($lname_err)) ? 'is-invalid' : ''; ?>"><?php echo $lname; ?></input>
                            <span class="invalid-feedback"><?php echo $lname_err;?></span>
                            <select class="form-select form-select-lg my-3" aria-label=".form-select-lg example"
                                name="project">
                                <option value="" selected>Choose project</option>
                                <?php while ( $rows = mysqli_fetch_array($res)) { ?>
                                <option value="<?php echo $rows['id'];  ?>"><?php echo $rows['project'];  ?>
                                </option>
                                <?php } 
                                mysqli_close($conn);?>
                            </select>
                        </div>
                        <input type="submit" class="btn btn-primary mt-3" value="Submit">
                        <a href="index.php" class="btn btn-secondary ml-2 mt-3">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>

</html>