<?php
session_start();

//single reusable delete function to deactivate data cells

include ('../include/db.php');

$page = $_GET['page'];
$id = $_GET['id'];

if($page == 'admin'){
    $table = 'user_master';
    $tableID = 'user_id';
}
else if($page == 'vehicles') {
    $table = 'vehicle_type_master';
    $tableID = 'vtype_id';
}

else if($page == 'slabs'){
    $table = 'slab_master';
    $tableID = 'slab_id';
}

$sql = "UPDATE $table SET flag = 0 WHERE $tableID ='$id'";
mysqli_query($con,$sql);
if ($con->query($sql) === TRUE) {
    echo "Record updated successfully";
} else {
    echo "Error updating record: " . $con->error;
}

header('Location: ../public/'.$page.'.php');
?>