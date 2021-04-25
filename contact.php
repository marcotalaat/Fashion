<?php
session_start();
include("include/inc.php");
?>
<?php
if($_SERVER["REQUEST_METHOD"] == "POST"){
//Get form
$name = filter_var($_POST["name"], FILTER_SANITIZE_SPECIAL_CHARS);
$email = filter_var($_POST["email"], FILTER_SANITIZE_SPECIAL_CHARS);
$msg = filter_var($_POST["msg"], FILTER_SANITIZE_SPECIAL_CHARS);

$admin_email = "marcotalaat355@yahoo.com";
$subject = "eCommerce contact form";
$header = "Name: " . $name . "\r\n" . "From: " . $email . "\r\n";
 // Form Error
 $contact_error = array();
 if (strlen($name) < 3){
    $contact_error[] = "Sorry you sould write full name !";
 };
 if (strlen($msg) < 3){
    $contact_error[] = "Sorry your message mustn't be less than 3 character !";
 };

if (empty($contact_error)){
mail($admin_email, $subject, $msg, $header);
 }

}


?>

<!-- Breadcrumb Begin -->
<div class="breadcrumb-option">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="breadcrumb__links">
                    <a href="./front-page.php"><i class="fa fa-home"></i> Home</a>
                    <span>Contact</span>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Breadcrumb End -->

<!-- Contact Section Begin -->
<section class="contact spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 col-md-6">
                <div class="contact__content">
                    <div class="contact__address">
                        <h5>Contact info</h5>
                        <ul>
                            <li>
                                <h6><i class="fa fa-map-marker"></i> Address</h6>
                                <address>16st : Example</address>
                            </li>
                            <li>
                                <h6><i class="fa fa-phone"></i> Phone</h6>
                                <p><span>125-711-811</span></p>
                            </li>
                            <li>
                                <h6><i class="fa fa-headphones"></i> Support</h6>
                                <p>marcotalaat355@yahoo.com</p>
                            </li>
                        </ul>
                    </div>
                    <div class="contact__form">
                        <h5>SEND MESSAGE</h5>
                        <?php
                        if(!empty($contact_error)){
                        foreach($contact_error as $error){
                        echo "<div class='alert alert-danger'>" . $error . "</div>";
                         } } ?>
                        <form action="<?php $_SERVER["PHP_SELF"] ?>" method="POST">
                            <input type="text" name="name" placeholder="Name">
                            <input type="email" name="email" placeholder="Email">
                            <textarea name="msg" placeholder="Message"></textarea>
                            <button type="submit" class="site-btn">Send Message</button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-md-6">
                <div class="contact__map">
                    <iframe
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d48158.305462977965!2d-74.13283844036356!3d41.02757295168286!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x89c2e440473470d7%3A0xcaf503ca2ee57958!2sSaddle%20River%2C%20NJ%2007458%2C%20USA!5e0!3m2!1sen!2sbd!4v1575917275626!5m2!1sen!2sbd"
                        height="780" style="border:0" allowfullscreen="">
                    </iframe>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Contact Section End -->

<!-- Instagram Begin -->
<?php include("include/instagram.php"); ?>
<!-- Instagram End -->

<?php
include("include/footer.php");