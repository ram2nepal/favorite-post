jQuery(document).ready( function() {

    jQuery(".favorite-post").click( function(e) {
        e.preventDefault();
        post_id = jQuery(this).attr("data-post_id");
        nonce = jQuery(this).attr("data-nonce");

        jQuery.ajax({
            type : "post",
            dataType : "json",
            url : myAjax.ajaxurl,
            data : {action: "add_favorite_post", post_id : post_id,},
            success: function(response) {

                if(response.type == "success") {
                    location.reload();
                }
                else {
                    alert("You need to log in to add favorites");
                }
            }
        })

    })

});