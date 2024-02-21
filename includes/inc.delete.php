<?php
include "inc.connection.php";

if (isset($_GET['deleteid'])){
    $id = $_GET['deleteid'];
    $sql = "DELETE FROM items WHERE id = $id;";
    $result = mysqli_query($conn, $sql);

    if ($result){
        echo "
            <script>
                alert('Data deleted successfully!')
                window.location = '../index.php' 
            </script>";
    }
    else {
        die(mysqli_error($conn));
    }
}

include "add_to_google_sheets.php";