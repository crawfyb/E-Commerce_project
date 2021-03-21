<?php
//ini_set('display_errors', 1); error_reporting(-1);

    if(isset($_POST['register'])) {
      require './dbconfig/db.php';

      //filter sanitze prevents writing scripts in fields which prevents hacking
      $forename = filter_var($_POST["forename"], FILTER_SANITIZE_STRING);
      $surname = filter_var($_POST["surname"], FILTER_SANITIZE_STRING);
      $street = filter_var($_POST["street"], FILTER_SANITIZE_STRING);
      $town = filter_var($_POST["town"], FILTER_SANITIZE_STRING);
      $postcode = filter_var($_POST["postcode"], FILTER_SANITIZE_STRING);
      $email = filter_var($_POST["email"], FILTER_SANITIZE_EMAIL);
      $username = filter_var($_POST["username"], FILTER_SANITIZE_STRING);
      $password = filter_var($_POST["password"], FILTER_SANITIZE_STRING);
      $passwordHashed = password_hash($password, PASSWORD_DEFAULT);
    $catagory = filter_var($_POST["catagory"], FILTER_SANITIZE_STRING);

      if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
          $stmt = $pdo -> prepare('SELECT * FROM emembers WHERE email = ? ');
          $stmt -> execute([$email]);
          $totalUsers = $stmt -> rowCount();

        //  echo $totalUsers . "<br >";

        if ($totalUsers > 0) {
          //echo "Email already taken <br >";
          $emailTaken =  "Email already taken";
        } else {
          $stmt = $pdo -> prepare('INSERT into emembers(forename, surname, street, town, postcode, email, username, password, catagory) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?) ');
          $stmt -> execute([$forename, $surname, $street, $town, $postcode, $email, $username, $passwordHashed, $catagory]);
          header('Location: http://localhost:8888/index.php');          
        }
      }
  //  echo $forename . " " . " " . $surname . " " . $password . " " . $catagory;
    }
?>

    <?php
    require './include/header.html';
    ?>

    <div class="container">
      <div class="card">
        <div class="card-header bg-light mb-3">Register</div>
          <div class="card-body">
            <form action="register.php" method="POST">

              <div class="form-group">
                <label for="forename">First Name</label>
                  <input required type="text" name="forename" class="form-control">
              </div>

              <div class="form-group">
                <label for="surname">Surname</label>
                  <input required type="text" name="surname" class="form-control">
              </div>

              <div class="form-group">
                <label for="street">Street Address</label>
                  <input required type="text" name="street" class="form-control">
              </div>

              <div class="form-group">
                <label for="town">Town</label>
                  <input required type="text" name="town" class="form-control">
              </div>

              <div class="form-group">
                <label for="postcode">Postcode</label>
                  <input required type="text" name="postcode" class="form-control">
              </div>

              <div class="form-group">
                <label for="email">Email</label>
                  <input required type="email" name="email" class="form-control">
              </div>

              <?php if(isset($emailTaken)) { ?>
                <h5 style="color: red"><?php echo $emailTaken ?></h5>
            <?php } ?>
            <br>
              <div class="form-group">
                <label for="username">Username</label>
                  <input required type="text" name="username" class="form-control">
              </div>

              <div class="form-group">
                <label for="password">Password</label>
                  <input required type="password" name="password" class="form-control">
              </div>

              <div class="form-group">
                <label for="catagory">Membership Type</label>
                <select  name="catagory">
                  <option value="Bronze">Bronze</option>
                  <option value="Silver">Silver</option>
                  <option value="Gold">Gold</option>
                </select>
              </div>


              <button name="register" type="submit" class="btn btn-primary" >Submit</button>



            </form>
          </div>


        </div>
    </div>

     <?php
      require './include/footer.html';
      ?>
