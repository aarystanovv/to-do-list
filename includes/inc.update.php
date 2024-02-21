<?php include "inc.connection.php";
    $id = $_GET['updateid'];
    $sql = "SELECT * FROM items WHERE id = '$id';";
    $result = mysqli_query($conn, $sql);

    $row = mysqli_fetch_assoc($result);
    $fetchId = $row['id'];
    $fetchItem = $row['todoItem'];
    $fetchDate = $row['todoDate'];

    if (isset($_POST['update'])){
        $updatedItem = $_POST['todoItem'];
        $updatedDate = $_POST['dueDate'];

        $sql = "UPDATE items SET id = '$id', todoItem = '$updatedItem', todoDate = '$updatedDate' WHERE id = '$id';";
        $result = mysqli_query($conn, $sql);

        if ($result){
            echo "
            <script>
                alert('Data updated successfully!')
                window.location = '../index.php' 
            </script>";
        }
        else {
            die(mysqli_error($conn));
        }
    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE-edge">
    <meta name="viewport" content="width-device-width, initial-scale=1.0">
    <title>To Do List App</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <style>
        body {
            background-image: url("images/bg.jpg");
            background-size: cover;
        }
        span {
            color: red;
        }
        a {
            text-decoration: none;
        }
    </style>
</head>
<body>
<section class="vh-100">
    <div class="container py-5 h-100">
        <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col col-lg-9 col-xl-7">
                <div class="card rounded-3">
                    <div class="card-body p-4">

                        <h4 class="text-center">update<span>List</span></h4>
                        <!-- Button trigger modal -->
                        <form method="POST">
                            <div class="mb-3">
                                <label for="todoItem" class="form-label">To Do Item</label>
                                <input name="todoItem" type="text" class="form-control" id="todoItem" value="<?php echo $fetchItem; ?>">
                            </div>
                            <div class="mb-3">
                                <label for="todoDate" class="form-label">Due Date</label>
                                <input name="dueDate" type="date" class="form-control" id="todoDate" value="<?php echo $fetchDate; ?>">
                            </div>

                            <div class="modal-footer">
                                <button type="submit" class="btn btn-secondary" data-bs-dismiss="modal"><a href='../index.php' class='text-light'>Back</a></button>
                                <button name="update" type="submit" class="btn btn-primary">Save</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
</body>
</html>