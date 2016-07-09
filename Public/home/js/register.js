$(document).ready(function(){

    var captcha_img = $('#captcha_img');
    var verifyimg = captcha_img.attr("src");
    captcha_img.attr('title', '点击刷新');
    captcha_img.attr("src", verifyimg+'?&random='+Math.random());
    $("form :input").blur(function(){
        $(this).parent().find(".tips").remove();
        //判断username
        if ($(this).is("#username")){
            if (this.value=="" || ( this.value != "" && !/^\w+$/.test(this.value) )){
                var hdw1 = $("<span class='tips error'>× 用户名不合法</span>");
                $(this).parent().append(hdw1);
            }else{
                //alert(this.value);
                var params = {username:this.value};
                var url = $('#username_ajax_url').val();
                $.ajax({
                    type: "POST",
                    url: url,
                    dataType: "json",
                    data: params,
                    success: function(msg){
                        if(msg.occupied == 1){
                            var hdw1 = $("<span class='tips error'>× 用户名被占用</span>");
                            $('#username').parent().append(hdw1);
                        }else if(msg.occupied == 0){
                            //var hdw1 = $("<span class='tips correct'>√ 用户名可用</span>");
                            //$('#username').parent().append(hdw1);
                        }
                    }
                });
            }
        }
        //end

        //判断password
        if ($(this).is("#password")){
            if (this.value=="" || this.value.length < 6){
                var hdw1 = $("<span class='tips error'>× 密码不得小于6位</span>");
                $(this).parent().append(hdw1);
            }else{
                //var hdw1 = $("<span class='tips correct'>√ 正确</span>");
                //$(this).parent().append(hdw1);
            }
        }
        //end

        //判断email
        if ($(this).is("#email")){
            if (this.value=="" || ( this.value!="" && !/^\w+((-\w+)|(\.\w+))*\@\w+((\.|-)\w+)*\.\w+$/.test(this.value) )){
                var hdw1 = $("<span class='tips error'>× 邮箱格式不正确</span>");
                $(this).parent().append(hdw1);
            }else{
                var params = {email:this.value};
                var url = $('#email_ajax_url').val();
                $.ajax({
                    type: "POST",
                    url: url,
                    dataType: "json",
                    data: params,
                    success: function(msg){
                        if(msg.occupied == 1){
                            var hdw1 = $("<span class='tips error'>× 此邮箱已被占用</span>");
                            $('#email').parent().append(hdw1);
                        }else if(msg.occupied == 0){
                            //var hdw1 = $("<span class='tips correct'>√ 正确</span>");
                            //$('#email').parent().append(hdw1);
                        }
                    }
                });
            }
        }
        //end

        //判断captcha
        if ($(this).is("#captcha")){
            if (this.value==""){
                var hdw1 = $("<span class='tips error'>× 验证码不能为空</span>");
                $(this).parent().append(hdw1);
            }
        }
        //end

    });
    //blur  end


    //提交
    $("#reg").click(function(){
        //$("form :input").trigger("blur");
        $("#password").trigger("blur");
        $("#captcha").trigger("blur");
        var hdw3 = $(".error").length;
        if($('#username').val() =="" || $('#email').val() ==""){
            $("#username").trigger("blur");
            $("#email").trigger("blur");
            return false;
        }
        if (hdw3){
            return false;
        }
    });
    //end

});

