$(document).ready(function() {
    window.onbeforeunload = function() {
        console.log(event.clientX);
        console.log(event.clientY);
        return this.event.clientX;
        alert(this.event.clientX);
        if(event.clientX>document.body.clientWidth&&event.clientY<0 || event.altKey){ 
            $.post('{:Url("Home/logout_stu")}');
        }
    }
});