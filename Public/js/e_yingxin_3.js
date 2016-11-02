$(document).ready(function(){
    $("#background").css({
        width: $(document).width(),
        height: $(document).height()
    })

    $("#background>img").css({
        width: $(document).width(),
        height: $(document).height()
    })
    
    
    setInterval(function() {
        $("#background").css({
            width: $(document).width(),
            height: $(document).height()
        })

        $("#background>img").css({
            width: $(document).width(),
            height: $(document).height()
        })
    },100)
    

    $('.mainForm input[type=text],.mainForm input[type=email],.mainForm textarea,.mainForm select')
    .hover(function(){$(this).attr('class','input_move')})
    .focus(function(){$(this).attr('class','input_move')})
    .blur(function(){$(this).attr('class','input_off')})
    .mouseout(function(){if(!$(this).is(":focus")){$(this).attr('class','input_off')}}) 
    $("#firstWant").change(function(){
        switch($(this).val())
        {
            case '0':$('#submit').attr('value','提交');break;
            case '1':$('#submit').attr('value','我要成为市场经理');break;
            case '2':$('#submit').attr('value','我要成为产品经理');break;
            case '3':$('#submit').attr('value','我要成为名记者');break;
            case '4':$('#submit').attr('value','我要成为DV大牛');break;
            case '5':$('#submit').attr('value','我要成为新媒体达人');break;
            case '6':$('#submit').attr('value','我要成为前端技术大神');break;
            case '7':$('#submit').attr('value','我要成为后端技术大神');break;
            case '8':$('#submit').attr('value','我要成为App技术大神');break;
            case '9':$('#submit').attr('value','我要加入腾讯蓝鲸');break;
            case '10':$('#submit').attr('value','我要加入公关部');break;
        }
    })
    $('#submit').click(function(event){
        event.preventDefault();
        if($('input[name=name]').val()==''||$('input[name=native_place]').val()==''||$('input[name=academy]').val()==''||$('input[name=class]').val()==''||$('input[name=mobile]').val()==''||$('input[name=email]').val()==''||$('textarea[name=intro]').val()==''||$('textarea[name=reason]').val()==''){alertDiv('以上内容都要认真填好哦，再检查检查还有哪些忘填了吧~');return;}
        if(!($('#male').is(':checked')||$('#female').is(':checked') )){alertDiv('请选择性别！');return;}
        var re1 = /^1\d{10}$/g;
        if(!re1.test($('input[name=mobile]').val())){alertDiv("请填写正确的手机号码！");return;}
        var re2 = /^(\w-*\.*)+@(\w-?)+(\.\w{2,})+$/g;
        if(!re2.test($('input[name=email]').val())){alertDiv("请填写正确的邮箱地址！");return;}
        if($('#firstWant').val()==0||$('#secondWant').val()==0){alertDiv("请填报志愿！");return;}
        var sexFlag=$('#male').is(':checked')?0:1;
        var requestData={
            name:$('input[name=name]').val(),
            sex:sexFlag,
            native_place:$('input[name=native_place]').val(),
            academy:$('input[name=academy]').val(),
            class:$('input[name=class]').val(),
            mobile:$('input[name=mobile]').val(),
            email:$('input[name=email]').val(),
            firstWant:$('#firstWant').val(),
            secondWant:$('#secondWant').val(),
            intro:$('textarea[name=intro]').val(),
            reason:$('textarea[name=reason]').val()
        }
        //console.log(requestData);
        $.post(postUrl, requestData, function(jqXHR){
            if(jqXHR['status']==200) {alertDiv('报名申请提交成功！');window.location.href=okUrl;}
            else { alertDiv(jqXHR['data']); }
        });
    })
    $('#confirmAlert').click(function(){
        $('#alert').css('visibility','hidden');
    })
})
function alertDiv(msg)
{
    $('#alert span').text(msg);
    $('#alert').css('visibility','visible');
}
