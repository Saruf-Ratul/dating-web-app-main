$(document).ready(function () {
    /*--------------------------------------------------------------------------
    |
    | CSRF TOEKN PASSING
    |
    |--------------------------------------------------------------------------*/
    $.ajaxSetup({
        beforeSend: function (xhr, type) {
            if (!type.crossDomain) {
                xhr.setRequestHeader(
                    "X-CSRF-Token",
                    $('meta[name="csrf-token"]').attr("content")
                );
            }
        },
    });
    /*--------------------------------------------------------------------------
    |
    | AJAX - LIKE-DISLIKE-MUTUTAL_POPUP TOGGLING
    |
    |--------------------------------------------------------------------------*/
    $(document).on("click", ".updateLikeStatus", function () {
        var like_status = $(this).text();
        var user_id = $("#user_id").val();
        var target_user_id = $(this).attr("target_user_id");
        var target_user_name = $(this).attr("target_user_name");
        $.ajax({
            type: "post",
            url: "/update-like-status",
            data: {
                like_status: like_status,
                user_id: user_id,
                target_user_id: target_user_id,
            },
            success: function (resp) {
                if (resp["like_status"] == 1) {
                    if(resp["mututal"] == 1){
                        Swal.fire({
                            icon: "success",
                            title: "It's a Match ❤️",
                            text: target_user_name + " - also liked you ",
                        });
                        $("#target-" + target_user_id).html(
                            "<a title='Status' class='updateLikeStatus btn btn-info' href='javascript:void(0)'>Dislike</a>"
                        );
                    }else{
                        $("#target-" + target_user_id).html(
                            "<a title='Status' class='updateLikeStatus btn btn-info' href='javascript:void(0)'>Dislike</a>"
                        );
                    }
                } else if (resp["like_status"] == 0) {
                    $("#target-" + target_user_id).html(
                        "<a title='Status' class='updateLikeStatus btn btn-info' href='javascript:void(0)'>Like</a>"
                    );
                }
            },
            error: function () {},
        });
    });
});
