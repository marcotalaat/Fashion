<?php
session_start();
if(isset($_SESSION['Username'])){
include("include/inc.php");
?>
<?php 
    $cat = (isset($_GET["cat"])) ? $_GET["cat"] : 0;
    $id = (isset($_GET["id"]) && is_numeric($_GET["id"])) ? $_GET["id"] : 0;
    //Select row by it's id
    $cat_id = $db->prepare("SELECT * FROM categories WHERE id = ?");
    $cat_id->execute(array($id));
    $cat_row = $cat_id->fetch();

    if ($cat == "delete") {
        $stmt = $db->prepare("DELETE FROM categories WHERE id = ?");
        $stmt->execute(array($_GET["id"]));
        header("location: front-page.php");
        exit;
    }elseif($cat == "edit"){ // Edit Page ?>
<div class="container">
    <h1 class="bold main-color">Edit Category</h1>
    <form action="?cat=update" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?php echo $id; ?>">
        <div class="form-group">
            <label for="name">Category Name</label>
            <input type="text" name="cat_name" class="form-control" id="name" value="<?php echo $cat_row["name"] ?>">
        </div>
        <div class="form-group">
            <label for="cat-desc">Description</label>
            <textarea name="cat_desc" class="form-control"
                id="cat-desc"><?php echo $cat_row["description"] ?></textarea>
        </div>
        <input type="submit" value="Edit Category" class="btn main-background white-color">
    </form>
</div>
<?php
    }elseif ($cat == "update") {
        $id = $_POST["id"];
        $cat_name = $_POST["cat_name"];
        $cat_desc = $_POST["cat_desc"];
    
        $stmt = $db->prepare("UPDATE categories SET name = ?, description = ? WHERE id = $id");
        $stmt->execute(array($cat_name, $cat_desc));
        header("location: front-page.php");
        exit; 
    }
?>
<?php include("include/footer.php") } ?>