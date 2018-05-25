$(document).ready(function() {
<<<<<<< HEAD
    window.onbeforeunload = function() {
        console.log(event.clientX);
        console.log(event.clientY);
        return this.event.clientX;
        alert(this.event.clientX);
        if(event.clientX>document.body.clientWidth&&event.clientY<0 || event.altKey){ 
            $.post('{:Url("Home/logout_stu")}');
=======
    window.onbeforeunload = function(event) {
        if(event.clientY<0 || event.altKey) {
            return '确认登出？';
            $.ajax({
                type: 'POST',
                url: '{:Url("Home/logout_stu")}'
            });
>>>>>>> 46cff3c3dd67eff30318b9ec5a58edf5d7e038ea
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