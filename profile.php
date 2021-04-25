<?php
session_start();
if(isset($_SESSION['Username'])){
ob_start();
include("include/inc.php");
?>
<?php
    $user_id = $_GET["id"];
    $page = $_GET["page"];
    if (isset($user_id) && is_numeric($user_id) && isset($page) && $page == "edit"){
    $single_user = $db->prepare("SELECT * FROM users WHERE id = ? ");
    $single_user->execute(array($user_id));
    $single_user_row = $single_user->fetch();

?>

<!-- Profile Templete -->
<section class="profile">
    <div class="container">
        <form action="?id=<?php echo $single_user_row["id"] ?>&page=update" method="POST" enctype="multipart/form-data">
            <div class="profile-photo-continer text-center">
            <?php if (empty($single_user_row["img"])){ ?>
                <div class="profile-photo set-bg" data-setbg="img/users/Avatar.png">
                <?php }else{
                    echo " <div class='profile-photo set-bg' data-setbg='img/users/" . $single_user_row['img'] . " '> ";
                } ?>
                    <div class="position-relative">
                        <label for="profile-photo">
                            <div class="input-file-profile">
                                <i class="fas fa-upload"></i>
                                <input type="file" id="profile-photo" name="profile-photo">
                            </div>
                        </label>
                    </div>
                </div>
                <div class="name">
                    <h4><?php echo $single_user_row["full_name"] ?></h4>
                    <h6>email: <?php echo $single_user_row["email"] ?></h6>
                </div>
            </div>
            <h3 class="text-center bold main-color p-3">Edit Profile</h3>
            <div class="form-edit-profile">
                <div class="form-group">
                    <label for="name" class="d-block">Full Name</label>
                    <input type="text" id="name" name="full-name" value="<?php echo $single_user_row["full_name"] ?>">
                </div>
                <div class="form-group">
                    <label for="username" class="d-block">Username</label>
                    <input type="text" id="username" name="username" value="<?php echo $single_user_row["username"] ?>">
                </div>
                <div class="form-group">
                    <label for="password" class="d-block">Password</label>
                    <input type="password" id="password" name="password"
                        value="<?php echo $single_user_row["password"]; ?>">
                </div>
                <div class="form-group">
                    <label for="email" class="d-block">E-mail</label>
                    <input type="email" id="email" name="email" value="<?php echo $single_user_row["email"] ?>">
                </div>
                <input type="submit" class="btn btn-primary" value="Edit Profile">
        </form>
    </div>
</section>
<!-- End of Profile Templete -->

<!-- Instagram Begin -->
<?php include("include/instagram.php"); ?>
<!-- Instagram End -->
<?php }elseif(isset($user_id) && is_numeric($user_id) && isset($page) && $page == "update"){
    if ($_SERVER["REQUEST_METHOD"] == "POST"){
    // Update profile 
    $full_name = $_POST["full-name"];
    $username = $_POST["username"];
    $password = $_POST["password"];
    $email = $_POST["email"];
    //Upload & Update Profile
    $profile_photo = $_FILES["profile-photo"];
    $profile_photo_name = $_FILES["profile-photo"]["name"];
    $profile_photo_type = $_FILES["profile-photo"]["type"];
    $profile_photo_tmp = $_FILES["profile-photo"]["tmp_name"];

    $photo_exp = explode(".", $profile_photo_name);
    $photo_meme = strtolower(end($photo_exp));
    if (in_array($photo_meme, img_allowed())){
        $photo_last_name = rand(0, 100000) . "_" . $profile_photo_name;
        move_uploaded_file($profile_photo_tmp, "img/users/" . $photo_last_name);
    }
    function img_present(){
        if (!isset($photo_last_name)){
            echo "Avatar.png";
        }else{
            echo $photo_last_name;
        }
    }
    // Insert data in table users
    $update_profile = $db->prepare("UPDATE users SET username = ?, full_name = ?, password = ?, email = ?, img = ? WHERE id = $user_id");
    $update_profile->execute(array($username, $full_name, $password, $email, empty($photo_last_name) ? "Avatar.png" : $photo_last_name ));
    header("location: front-page.php");
    exit;
    }// End of Post
    
} else{
    echo "Error!";
    header("location: front-page.php");
} ?>
<?php include("include/footer.php"); } ?>