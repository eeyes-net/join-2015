$(function(){
    var Height = parseInt($(window).height());
    
    $("#background").css({
        width: $(window).width(),
        height: $(window).height()
    })

    $("#background>img").css({
        width: $(window).width(),
        height: $(window).height()
    })
    
    $("#title2").css({
        "margin-top": Height * 0.07 + 'px'
    })

    var oUl_1=document.getElementById("ul_1");
    var oUl_2=document.getElementById("ul_2");
    var oUl_3=document.getElementById("ul_3");
    var oPic1=document.getElementById("pic1");
    var oPic2=document.getElementById("pic2");
    var oPic3=document.getElementById("pic3");
    var oUl=document.getElementsByTagName("ul");
    var guide = document.getElementById("guide");
    var x=0;
    var y=0;
    var z=0;

    oUl_1.onclick=function(){
        if (x==0) {
            oPic1.src=rootUrl + "/images/top.png";
            oUl[0].style.display="block";
            x=1;
            guide.style.display="none"
        }
        else{
            oPic1.src=rootUrl + "/images/bottom.png";
            oUl[0].style.display="none";
            x=0;
            guide.style.display="block";
        }
    }
    oUl_2.onclick=function(){
        if (y==0) {
            oPic2.src=rootUrl + "/images/top.png";
            oUl[1].style.display="block";
            y=1;
            guide.style.display="none"
        }
        else{
            oPic2.src=rootUrl + "/images/bottom.png";
            oUl[1].style.display="none";
            y=0;
            guide.style.display="block";
        }
    }
    oUl_3.onclick=function(){
        if (z==0) {
            oPic3.src=rootUrl + "/images/top.png";
            oUl[2].style.display="block";
            z=1;
            guide.style.display="none"
        }
        else{
            oPic3.src=rootUrl + "/images/bottom.png";
            oUl[2].style.display="none";
            z=0;
            guide.style.display="block";
        }
    }

    setInterval(function() {
       $("#background").css({
            width: $(window).width(),
            height: $(window).height()
        })

        $("#background>img").css({
            width: $(window).width(),
            height: $(window).height()
        })
    },100)    

})