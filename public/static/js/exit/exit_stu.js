$(document).ready(function() {
    var isF5 = false;
    window.document.onkeydown = function() {
        if (event.keyCode==116) {
            isF5 = true;
        }
    }
    window.onbeforeunload = function() {
        console.log('isF5:'+isF5);
        if (!isF5) {
            return '关闭';
            $.ajax({
                url: '{:Url("Home/logout_stu")}'
            });

        }
    }
});