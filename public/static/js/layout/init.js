function init() {
    var myDate = new Date();
    var dayStr = "日一二三四五六";
    var uname = document.getElementById('uname');
    if ((!uname && typeof(uname)!="undefined" && uname!=0 && uname!="") || uname.value=="") {
        jQuery("#welcome").html("欢迎！<br>当前时间：" +
            myDate.getFullYear().toString() + "年" + myDate.getMonth().toString() + "月" +
            myDate.getDate().toString() + "日 周" + dayStr.charAt(myDate.getDay()) + " " +
            myDate.getHours().toString() + "时" + myDate.getMinutes().toString() + "分" + myDate.getSeconds().toString() + "秒");
    } else {
        jQuery("#welcome").html("欢迎，" + uname.value + "！<br>当前时间：" +
            myDate.getFullYear().toString() + "年" + myDate.getMonth().toString() + "月" +
            myDate.getDate().toString() + "日 周" + dayStr.charAt(myDate.getDay()) + " " +
            myDate.getHours().toString() + "时" + myDate.getMinutes().toString() + "分" + myDate.getSeconds().toString() + "秒");
    }
    window.setTimeout(init, 1000);
}