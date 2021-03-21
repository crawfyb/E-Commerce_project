<?php
   $host = 'localhost';
    $user = 'root';
    $password = 'root';
   $dbname = 'Ecommerce_project';

   //set DSN
   $dsn = 'mysql:host=' . $host .'; dbname=' . $dbname;

   try {
     //create pdo instance
     $pdo = new PDO($dsn, $user, $password);
     //fetch objects by name rather than array number
     $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
     $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
     //echo "connected successfully";
   } catch (PDOException $e) {
     echo "error: " . $e->getMessage();
   }


 ?>
