<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <title>Header</title>
</head>

<body>

    <nav class="navbar navbar-expand navbar-light bg-light p-3">
        <div class="container-fluid">
            <div class="navbar-nav mx-3">
                <a class="nav-link fs-5 <?php if ($page == 'home') {echo 'active';}  ?>" href="index.php">Employees</a>
                <a class="nav-link fs-5 <?php if ($page == 'projects') {echo 'active';}  ?>"
                    href="projects.php">Projects</a>
            </div>
            <h2>Project Manager</h2>
        </div>
    </nav>

</body>

</html>