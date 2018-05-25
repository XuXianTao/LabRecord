$(document).ready(function() {
    window.onbeforeunload = function() {
        if(event.clientX>document.body.clientWidth&&event.clientY<0 || event.altKey){ 
            $.post('{:Url("Home/logout_admin")}');
        }
    }
});