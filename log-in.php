<?php
session_start();
include("include/header.php");
include("include/database.php");
include("include/functions.php");
include("include/loading.php");

?>
<?php
  if ($_SERVER["REQUEST_METHOD"] == "POST" && empty($form_error) ) {
    $form_error = array();
    if($_POST["username"] == ""){
        $form_error[] = "Username is Required";
    }
    if($_POST["password"] == ""){
        $form_error[] = "Password is Required";
    }
        $user = filter_var($_POST["username"], FILTER_SANITIZE_SPECIAL_CHARS);
        $pass = filter_var($_POST["password"], FILTER_SANITIZE_SPECIAL_CHARS);
        $hashedPass = sha1($pass);
    
        $stmt = $db->prepare("SELECT admin, id ,username, password FROM users WHERE username = ? AND password = ? ");
        $stmt->execute(array($user, $hashedPass));
        $row = $stmt->fetch();
        $count = $stmt->rowCount();

        if ($count > 0) {
            $_SESSION["Username"] = $user;
            $_SESSION["ID"] = $row["id"];
            $_SESSION["Admin"] = $row["admin"];
            header("location: index.php");
            exit;
        }
    }
?>
<!-- Section Sign In -->
<section class="log-page">
    <div id="backgorund" class="backgorund-singin">
        <?php
    echo  "<img src='img/design/sign-in.jpg'>";
    ?>
    </div>

    <div class="container">
        <div class="row">
            <div class="content col-sm-6">
                <h1 class="main-color bold">Welcome Back!</h1>
                <p class="lead">Lorem, ipsum dolor sit amet consectetur adipisicing elit. Officiis facilis magni non
                    eaque saepe amet quis repudiandae rem sint.</p>
                <span>Are you registerd ? or <a href="sign-up.php" class="create-user">Create new user</a></span>
            </div>
            <form class="log-in col-sm-4 offset-sm-2" action="<?php $_SERVER["PHP_SELF"] ?>" method="POST">
                <h3 class="text-center bold white-color">Log In</h3>
                <input type="text" name="username" require>
                <input type="password" name="password" require>
                <?php 
                if(!empty($form_error)){
                    foreach($form_error as $err){
                        echo "<span class='d-block white-color'>" .  $err . "</span>";
                    }
                }
                ?>
                <input type="submit" value="Log In">
            </form>
        </div>
    </div>
    <div class="text-center arrow-left">
        <i class="fas fa-arrow-left fa-2x"></i>
    </div>​
</section>



<?php include("include/footer.php");