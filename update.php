<?php
//ini_set('display_errors', 1); error_reporting(-1);
    session_start();

    if(isset($_SESSION['userID'])) {
      require './dbconfig/db.php';

      $userID = $_SESSION['userID'];

      if (isset($_POST['update'])) {
        $forename = filter_var($_POST["forename"], FILTER_SANITIZE_STRING);
        $surname = filter_var($_POST["surname"], FILTER_SANITIZE_STRING);
        $street = filter_var($_POST["street"], FILTER_SANITIZE_STRING);
        $town = filter_var($_POST["town"], FILTER_SANITIZE_STRING);
        $postcode = filter_var($_POST["postcode"], FILTER_SANITIZE_STRING);
        $email = filter_var($_POST["email"], FILTER_SANITIZE_EMAIL);
        $username = filter_var($_POST["username"], FILTER_SANITIZE_STRING);
        $catagory = filter_var($_POST["catagory"], FILTER_SANITIZE_STRING);

        $stmt = $pdo -> prepare('UPDATE emembers SET forename=?, surname=?, street=?, town=?, postcode=?, email=?, username=?, catagory=? WHERE id =?');
        $stmt -> execute([$forename, $surname, $street, $town, $postcode, $email, $username, $catagory, $userID]);
        }

      $stmt = $pdo -> prepare('SELECT * FROM emembers WHERE id = ?');
      $stmt -> execute([$userID]);

      $user = $stmt -> fetch();



    }

?>

    <?php
    require './include/header.html';
    ?>

    <div class="container">
      <div class="card">
        <div class="card-header bg-light mb-3">Register</div>
          <div class="card-body">
            <form action="update.php" method="POST">

              <div class="form-group">
                <label for="forename">First Name</label>
                  <input  type="text" name="forename" class="form-control" value="<?php echo $user->forename ?>">
              </div>

              <div class="form-group">
                <label for="surname">Surname</label>
                  <input  type="text" name="surname" class="form-control" value="<?php echo $user->surname ?>">
              </div>

              <div class="form-group">
                <label for="street">Street Address</label>
                  <input  type="text" name="street" class="form-control" value="<?php echo $user->street ?>">
              </div>

              <div class="form-group">
                <label for="town">Town</label>
                  <input  type="text" name="town" class="form-control" value="<?php echo $user->town ?>">
              </div>

              <div class="form-group">
                <label for="postcode">Postcode</label>
                  <input  type="text" name="postcode" class="form-control"value="<?php echo $user->postcode ?>">
              </div>

              <div class="form-group">
                <label for="email">Email</label>
                  <input  type="email" name="email" class="form-control" value="<?php echo $user->email ?>">
              </div>

              <?php if(isset($emailTaken)) { ?>
                <h5 style="color: red"><?php echo $emailTaken ?></h5>
            <?php } ?>
            <br>
              <div class="form-group">
                <label for="username">Username</label>
                  <input required type="text" name="username" class="form-control" value="<?php echo $user->username ?>">
              </div>

              <div class="form-group">
                <label for="catagory">Membership Type</label>
                <select  name="catagory">
                  <option value="Bronze">Bronze</option>
                  <option value="Silver">Silver</option>
                  <option value="Gold">Gold</option>
                </select>
              </div>


              <button name="update" type="submit" class="btn btn-primary">Update details</button>



            </form>
          </div>


        </div>
    </div>

     <?php
      require './include/footer.html';
      ?>
