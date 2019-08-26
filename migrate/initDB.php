<?php

include ('../include/db.php');

$con = mysqli_connect("localhost:3306","root","admin");
if(!$con){
    die("connection failed".mysqli_connect_error());
}
else{ 
    echo "connected";
    //Create Schema/Database
    $stmt0 = "CREATE SCHEMA `parking` DEFAULT CHARACTER SET utf8" ;
    mysqli_query($con, $stmt0);
    //create User_Master Table
    $stmt1 = "CREATE TABLE `parking`.`user_master` (
        `user_id` VARCHAR(20) NOT NULL,
        `uname` VARCHAR(45) NULL,
        `password` VARCHAR(150) NULL,
        `fullname` VARCHAR(100) NULL,
        `id_proof_type` VARCHAR(45) NULL DEFAULT NULL,
        `id_number` VARCHAR(45) NULL DEFAULT NULL,
        `emp_no` VARCHAR(45) NULL DEFAULT NULL,
        `phone` VARCHAR(12) NULL,
        `address` VARCHAR(500) NULL,
        `type` VARCHAR(30) NULL,
        `flag` INT NULL,
        `last_login` VARCHAR(45) NULL,
        PRIMARY KEY (`user_id`))
      ENGINE = InnoDB
      DEFAULT CHARACTER SET = utf8
      COLLATE = utf8_danish_ci";
    mysqli_query($con, $stmt1);

    $stmt2 = "CREATE TABLE `parking`.`vehicle_type_master` (
                `vtype_id` VARCHAR(20) NOT NULL,
                `vtype_name` VARCHAR(45) NULL,
                `flag` INT NULL,
                `created_date` VARCHAR(45) NULL,
                `created_by` VARCHAR(45) NULL,
                `shortcut` VARCHAR(5) NULL,
                PRIMARY KEY (`vtype_id`))
            ENGINE = InnoDB
            DEFAULT CHARACTER SET = utf8";
    mysqli_query($con, $stmt2);

    $stmt3 = "CREATE TABLE `parking`.`slab_master` (
                `slab_id` VARCHAR(45) NOT NULL,
                `slab_name` VARCHAR(45) NULL,
                `vehicle_type` VARCHAR(45) NULL,
                `slab_from` VARCHAR(45) NULL,
                `slab_to` VARCHAR(45) NULL,
                `slab_charges` VARCHAR(45) NULL,
                `flag` INT NULL,
                `created_date` VARCHAR(45) NULL,
                `created_by` VARCHAR(45) NULL,
                PRIMARY KEY (`slab_id`))
            ENGINE = InnoDB
            DEFAULT CHARACTER SET = utf8";
    mysqli_query($con,$stmt3);

}


?>