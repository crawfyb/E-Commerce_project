<?php
    session_start();
    include './dbconfig/db.php';


    $stmt = $pdo -> query('SELECT * from estock');

   while ($row = $stmt->fetch()) {
      echo $row->stockNo . 'stock';
      echo $row->description . 'stock';
      echo $row->price . 'stock';
    }


    //$stmt-> execute();
  //  $stock = $stmt->fetch();
    //echo $stock;
        ?>
        <?php


 ?>

            <?php
            require './include/header.html';
            ?>

          <table>
            <th>Stock number</th>
            <th>Description</th>
            <th>Price</th>
            <th>Stock</th>



            <?php
             require './include/footer.html';
             ?>
