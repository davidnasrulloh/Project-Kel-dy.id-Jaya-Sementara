<?php

$connection = mysqli_connect("localhost", "root", "", "db_dyid");
if (mysqli_connect_errno()) {
    echo mysqli_connect_errno();
}

// $connection = mysqli_connect("sql207.epizy.com", "epiz_28888910", "StnN9unSUj3Ygdf", "epiz_28888910_db_dyid");
// if (mysqli_connect_errno()) {
//     echo mysqli_connect_errno();
// }