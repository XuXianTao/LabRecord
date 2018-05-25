$(document).ready(function() {
    window.onbeforeunload = function(event) {
        if(event.clientY<0 || event.altKey) {
            return '确认登出？';
            $.ajax({
                type: 'POST',
                url: '{:Url("Home/logout_stu")}'
            });
        }
        console.log(event.clientY);
        console.log(event.altKey);
    }
});
function ccc(){
    console.log('Y:'+event.clientY);
    console.log('altKey'+event.altKey);
}
$(window).keydown(ccc);
$(window).click(ccc);