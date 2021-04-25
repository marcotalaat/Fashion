$(function () {
    /*--------------------------
        Comment System
    -----------------------------*/
    $(".add-comment").on("click", function () {
        $.ajax({
            method: "POST",
            url: "comment.php",
            data: $("#form-comment").serialize(),
            success: function(){
                loadComment();
                deleteComment();
                $(".comment").val('');
            }
        })
    })

    // Load comment in HTML file
    function loadComment(){
        var commentValue =  $(".delete-comment").children().first().val();
        $.ajax({
            method: "POST",
            url: "get-comment.php",
            data: {post_id: $(".post").val(), comment_id: commentValue},
            success: function(data){
                $(".load-comment").html(data);
                $(".comment-count").text($(".comment-number").val() + " Comment(s)");
                $(".header-comment-number").text($(".comment-number").val() + " Comment(s)");
                deleteComment();
                $(".comment").val('');
            }
        })
    }
    /* Delete Comment */
    function deleteComment(){
        $(".delete-comment").click(function(){
            var commentValue =  $(this).children().first().val();
        $.ajax({
                method: "POST",
                url: "delete-comment.php",
                data: {comment_id: commentValue},
                success: function(){
                    loadComment();
                    $(".comment").val('');
                }
            })
        })
    }
    deleteComment()
    /*-------------------------------
        Like button Comment
    ---------------------------------*/
    $(".like-comment i").one("click",function(){
        $(this).addClass("fas");
            $(this).next().text((parseInt($(this).next().text()) + 1));
            var commentValue =  $(this).prev().val();
            console.log(commentValue)
            $.ajax({
                method: "POST",
                url: "like-comment.php",
                data: {comment_id: commentValue},
                success: function(){
                    
                }
            })
    })

    /*---------------
       Search
    -----------------*/
/*     $(".search-input").on("input", function(){
        var searchVal = $(this).val();
        $.ajax({
            method: "POST",
            url: "search.php",
            data: {search: searchVal},
            success: function(data){
                $(".search-model").load(data);
            }
        })
    }) */

})