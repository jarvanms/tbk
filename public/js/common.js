//toast 手机端使用
function showNotice(content){
    // 创建相应样式的div
    var obj = $("<p id='warming' style='z-index: 100;bottom: 8%;position: fixed; left:50%;margin-left:-4.17rem;max-width: 10.34rem;padding:0 .4rem;text-align: center;line-height: 2.5rem;font-size:1rem;word-wrap:break-word;overflow:hidden; color: #fff;background: rgba(0, 0, 0, 0.7);opacity: 0;'>  </p>");
    $("body").append(obj);

    fnInfo(content);
    //显示错误提示内容
    function fnInfo(content)
    {
        var oInfo = document.getElementById("warming");
        oInfo.innerHTML=content;
        oInfo.style.opacity=1;
        setTimeout(function(){
            oInfo.style.opacity=0;
        },1500);
    }
}