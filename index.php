<?php
    session_start();
      if (isset($_SESSION['userID'])) {
        require './dbconfig/db.php';

        $userID = $_SESSION['userID'];

        $stmt = $pdo -> prepare('SELECT * FROM emembers WHERE id = ?');
        $stmt -> execute([$userID]);

        $user = $stmt -> fetch();

        if ($user->catagory === 'Bronze') {
          $message = 'You have a bronze memberhsip';
        }
        if ($user->catagory === 'Silver') {
          $message = 'You have a Silver memberhsip';
        }
        if ($user->catagory === 'Gold') {
        $message = 'You have a gold memberhsip';
        }
      }


?>

    <?php
    require './include/header.html';
    ?>

    <div class="container">
      <div class="card bg-light mb-3">
        <div class="card-header">
          <?php if(isset($user)) { ?>
            <h5>Welcome <?php echo $user->forename ?></h5>
        <?php  } else { ?>
          <h5>Welcome guest</h5>
        <?php } ?>
        </div>

        <div class="card-body">
          <?php if (isset($user)) { ?>
            <h5>Welcome <?php echo $message ?></h5>
            <div>
            <img src="./images/<?php echo $user->catagory ?>.png" >
            </div>
        <?php  } else { ?>
          <h4>please login</h4>
        <?php } ?>
        </div>
      </div>
    </div>

     <?php
      require './include/footer.html';
      ?>
