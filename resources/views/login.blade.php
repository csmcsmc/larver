用户名：<input type="text" id="name">
密码：<input type="text" id="password">
<button id="send">登录</button>
<span id="ts"></span>
<script src="http://code.jquery.com/jquery-latest.js"></script>
<script>
    $("#send").click(function () {
        var name=$("#name").val();
        var password=$("#password").val();
        $.ajax({
            url:"<?php echo url('/login/login_action');?>",
            data:{
                type:"post",
                name:name,
                password:password,
            },
            dataType:"json",
            success:function (res) {
                if (res.status=='yes'){
                    window.location.href="<?php echo url('/show');?>";
                } else if (res.status=='no') {
                    $("#ts").html(res.data);
                    $("#ts").css("color","red");
                    $("#name").val("");
                    $("#password").val("");
                    setTimeout(function(){
                        $("#ts").html("");
                    },3000);
                }
            }
        })
    })
</script>