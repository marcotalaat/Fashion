<?php
session_start();
ob_start();
include("include/inc.php");
?>
<?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $fullname = filter_var($_POST["fullname"], FILTER_SANITIZE_SPECIAL_CHARS);
        $user = filter_var($_POST["username"], FILTER_SANITIZE_SPECIAL_CHARS);
        $pass = filter_var($_POST["password"], FILTER_SANITIZE_SPECIAL_CHARS);
        $email = filter_var($_POST["email"], FILTER_SANITIZE_SPECIAL_CHARS);
        $hash = sha1($pass);

        $form_errors = array();
        if (strlen($fullname) == ""){
            $form_errors[] = "Fullname oblegatory";
        }
        if (strlen($user) == ""){
            $form_errors[] = "Username oblegatory";
        }
        if (strlen($pass) == ""){
            $form_errors[] = "password oblegatory";
        }
        if (strlen($email) == ""){
            $form_errors[] = "E-mail oblegatory";
        }

        if(empty($form_errors)){
            $stmt = $db->prepare("INSERT INTO 
                                                users (username, password, email, full_name, date) 
                                                VALUES (:user, :pass, :email, :fullname, now())");
            $stmt->execute(array(
                "user" => $user,
                "pass" => $hash,
                "email" => $email,
                "fullname" => $fullname
            ));
            $_SESSION["Username"] = $user;
            header("location: index.php");
            exit;
        }

    }
?>
<section class="sign-page">
    <div class="container">
        <div class="row animate__animated">
            <form class="sign-up col-sm-8 offset-sm-2" action="<?php $_SERVER["PHP_SELF"] ?>" method="POST">
            <?php 
                        if (!empty($form_errors)){
                            foreach($form_errors as $form_error){
                                echo "<div class='alert alert-danger' >" . $form_error . "</div>";
                            }
                        }
                        ?>
                <input type="text" name="fullname" placeholder="Full name" class="animate__animated animate__fadeInUp">
                <input type="text" name="username" require placeholder="Username" class="animate__animated animate__fadeInUp">
                <input type="password" name="password" require placeholder="Password" class="animate__animated animate__fadeInUp ">
                <input type="email" name="email" placeholder="E-mail" class="animate__animated animate__fadeInUp">
                <input type="submit" value="Sign Up" class="animate__animated animate__fadeInUp">
                <h6 class="text-center">Do you want to back to <a class="main-color" href="index.php">sign in</a> ?</h6>
            </form>
        </div>
    </div>
</section>
<?php include("include/footer.php");