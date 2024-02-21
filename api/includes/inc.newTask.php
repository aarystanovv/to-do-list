<?php
include "inc.connection.php";
if (isset($_POST['add'])){
    $todoItem = $_POST['todoItem'];
    $dueDate = $_POST['dueDate'];

    if(!empty($todoItem) && !empty($dueDate)){
        $query = "INSERT INTO items (todoItem, todoDate) VALUES ('$todoItem', '$dueDate');";
        $query_exec = mysqli_query($conn, $query);

        if ($query_exec){
            echo "
            <script>
                alert('Data successfully inserted!')
                window.location = '../index.php' 
            </script>";
        }
        else{
            echo "
            <script>
                alert('Something went wrong!')
                window.location = '../index.php' 
            </script>";
        }
    }
    else{
        echo "
            <script>
                alert('Something went wrong!')
                window.location = '../index.php' 
            </script>";
    }
}