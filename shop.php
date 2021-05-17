<?php

ini_set('display_errors', 1); error_reporting(-1);
    session_start();

    include './dbconfig/db.php';



        ?>
        <?php


 ?>


            <?php
            require './include/header.html';
            ?>
            <div class="">
              <br>
              <br>
              <br>
              <br>
            </div>
            <div class="col-12">

          <table  class="table table-striped">
            <t>
            <th>Stock number</th>
            <th>Description</th>
            <th>Price</th>
            <th>Stock</th>
            <th>image</th>
            <th>quantity</th>
            <th></th>
          </t>
            <?php     $stmt = $pdo -> query('SELECT * from estock');

            $stmt->execute();
                //$stmt->store_result();
              //  $stmt->bind_result($stockNo,$description,$price,$qtyInStock);
              while ($row = $stmt->fetch()) {


                  // code...

                // $stmt->execute();
                // $products = $stmt->fetchAll();
                //
                // echo $products

              ?>
              <tr>
              <td><?php  echo $row->stockNo ?></td>
              <td><?php  echo $row->description ?></td>
              <td><?php  echo $row->price ?></td>
              <td><?php  echo $row->qtyInStock ?></td>
              <td><img src="./images/<?php echo $row->stockNo?>.jpeg" > </td>
              <td>
                <select class="" name="<?php $stockNo ?>" form="orderform">
                  <?php for($i=0;$i<$row->qtyInStock+1;$i++) {?>
                    <option value="<?php echo $i ?>"><?php echo $i ?></option>
                    <?php }; ?>
                </select>
              </td>

            </tr>
            <?php
            } ?>
            </table>



            <form action="placeOrder.php" method ="POST" id="orderform">
               <input type="submit" value="order">
               </form>



            <?php
             require './include/footer.html';
             ?>
