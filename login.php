<?php
//ini_set('display_errors', 1); error_reporting(-1);
    session_start();

    if(isset($_POST['login'])) {
      require './dbconfig/db.php';


      $username = filter_var($_POST["username"], FILTER_SANITIZE_STRING);
      $password = filter_var($_POST["password"], FILTER_SANITIZE_STRING);

      $stmt = $pdo -> prepare('SELECT * FROM emembers WHERE username = ?');
      $stmt -> execute([$username]);
      $user = $stmt ->fetch();

      if(isset($user)) {
        if(password_verify($password, $user -> password)) {
          //echo "The password is correct";
          $_SESSION['userID'] = $user -> id;
          header('Location: http://localhost:8888/index.php');
        }else {
          //echo "Username or Password Incorrect";
          $loginWrong = "Username or Password Incorrect";

        }
      }
    }
?>

    <?php
    require './include/header.html';
    ?>

    <div class="container">
      <div class="card">
        <div class="card-header bg-light mb-3">Register</div>
          <div class="card-body">
            <form action="login.php" method="POST">

              <div class="form-group">
                <label for="username">Username</label>
                  <input required type="text" name="username" class="form-control">
              </div>

              <div class="form-group">
                <label for="password">Password</label>
                  <input required type="password" name="password" class="form-control">
              </div>

              <?php if(isset($loginWrong)) { ?>
                <h5 style="color: red"><?php echo $loginWrong ?></h5>
            <?php }  ?>

              <button name="login" type="submit" class="btn btn-primary" >Login</button>

            </form>
          </div>


        </div>
    </div>

     <?php
      require './include/footer.html';
      ?>
