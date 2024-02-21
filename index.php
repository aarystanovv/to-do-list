<?php include "includes/inc.connection.php"; ?>
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

                        <h4 class="text-center">todo<span>List</span></h4>
                        <!-- Button trigger modal -->
                        <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#staticBackdrop"><i class="fa-solid fa-plus"></i>New Task</button>

                        <!-- Modal -->
                        <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5" id="staticBackdropLabel">New Task</h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="includes/inc.newTask.php" method="POST">
                                            <div class="mb-3">
                                                <label for="todoItem" class="form-label">To Do Item</label>
                                                <input name="todoItem" type="text" class="form-control" id="todoItem">
                                            </div>
                                            <div class="mb-3">
                                                <label for="todoDate" class="form-label">Due Date</label>
                                                <input name="dueDate" type="date" class="form-control" id="todoDate">
                                            </div>

                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                <button name="add" type="submit" class="btn btn-primary">Add</button>
                                            </div>
                                        </form>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <table class="table">
                            <thead>
                            <tr>
                                <th scope="col">No.</th>
                                <th scope="col">To Do Items</th>
                                <th scope="col">Due Date</th>
                                <th scope="col">Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $sql = "SELECT * FROM items";
                            $result = mysqli_query($conn, $sql);

                            if ($result){
                                while ($row = mysqli_fetch_assoc($result)){
                                    $id = $row['id'];
                                    $fetchItem = $row['todoItem'];
                                    $fetchDate = $row['todoDate'];

                                    echo " 
                                                <tr>
                                                    <td>".$id."</td>
                                                    <td>".$fetchItem."</td>
                                                    <td>".$fetchDate."</td>
                                                    <td>
                                                        <button class='btn btn-success'><a href='includes/inc.update.php?updateid=".$id."' class='text-light'><i class='fa-solid fa-pen-to-square'></i>Update</a></button>
                                                        <button class='btn btn-danger' onclick='finishTask(".$id.")'><i class='fa-solid fa-trash'></i>Finished</button>
                                                    </td>
                                                </tr>";
                                }
                            }
                            ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
    function finishTask(taskId) {
        if (confirm('Are you sure you want to mark this task as finished?')) {
            var formData = new FormData();
            formData.append('todoItem', taskId); // добавьте taskId в FormData

            fetch('add_to_google_sheets.php', {
                method: 'POST',
                body: formData
            })
                .then(response => response.text())
                .then(result => {
                    alert(result);
                    // После завершения задачи вызываем скрипт для удаления из базы данных
                    deleteTask(taskId);
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        }
    }

    function deleteTask(taskId) {
        fetch('includes/inc.delete.php?deleteid=' + taskId)
            .then(response => response.text())
            .then(result => {
                alert(result);
                window.location.reload();
            })
            .catch(error => {
                console.error('Error:', error);
            });
    }


</script>
</body>
</html>
