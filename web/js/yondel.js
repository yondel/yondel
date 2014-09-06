(function($) {
    // 名前を登録する
    $("#rgstUserName").bind("click", function() {
        var userName = $("#userName").val();
        localStorage.setItem("userName" , userName);
    });
})(jQuery);
