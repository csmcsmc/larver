添加用户名：<input type="text" id="name">
添加密码：<input type="text" id="password">
<button id="send">添加</button> <button id="tui">退出登录</button>
<table border="1" id="tab">

</table>
<script src="http://code.jquery.com/jquery-latest.js"></script>

<div id="div" style="position: absolute;left: 50%; top:30%;display: none">
    <span id="idd" hidden></span>
    用户名：<input id="ip1" type="text">
    <br><br>
    密码：<input id="ip2" type="text">
    <br><br>
    <input type="button" value="修改" onclick="up()">
    <input type="button" value="关闭" onclick="open1()">
</div>

<script>
    show();
    function show(){
        $.ajax({
            url:"<?php echo url('/showa');?>",
            dataType:"json",
            success:function (res) {
                var arr=res.status;
                tr='';
                tr=tr+"<tr><td>ID</td><td>用户名</td><td>密码</td><td>操作</td></tr>";
                $.each(arr,function (k,v) {
                    tr=tr+'<tr>';
                    tr=tr+"<td>"+v['id']+"</td>";
                    tr=tr+"<td>"+v['name']+"</td>";
                    tr=tr+"<td>"+v['password']+"</td>";
                    tr=tr+"<td><button onclick='del("+v['id']+")'>删除</button>" +
                        "<button onclick="+"update("+v['id']+",'"+v['name']+"','"+v['password']+"')"+">修改</button></td>";
                    tr=tr+'</tr>';
                })
             $("#tab").html(tr);
            }
        })
    }
    //添加
    $("#send").click(function () {
        var name=$("#name").val();
        var password=$("#password").val();
        $.ajax({
            url:"<?php echo url('/add'); ?>",
            data:{
                type:"post",
                name:name,
                password:password,
            },
            dataType:"json",
            success:function (res) {
                if (res.status=='ok') {
                    $("#name").val("");
                    $("#password").val("");
                    show();
                }else{
                    $("#name").val("");
                    $("#password").val("");
                    alert('添加失败');
                }
            }
        })

    })
    //删除
    function del(id){
        $.ajax({
            url:"<?php echo url('/delete') ?>",
            data:{
                type:"post",
                id:id,
            },
            dataType:"json",
            success:function (res) {
                if (res.status=="ok") {
                    show();
                }else{
                    alert("删除失败！")
                }
            }
        })
    }
    //修改弹出层
    function update(id,name,password) {
        $("#idd").html(id);
        $("#ip1").val(name);
        $("#ip2").val(password);
        document.getElementById("div").style.display="block";
    }
    //修改操作
    function up() {
        var idd=$("#idd").html();
        var ip1=$("#ip1").val();
        var ip2=$("#ip2").val();
        $.ajax({
            url:"<?php echo url('/update'); ?>",
            data:{
                type:"post",
                id:idd,
                name:ip1,
                password:ip2,
            },
            dataType:"json",
            success:function (res) {
                //console.log(res);
                if (res.status=='ok') {
                    show();
                    document.getElementById("div").style.display="none";
                }else{
                    $("#name").val("");
                    $("#password").val("");
                    alert('修改失败');
                }
            }
        })
    }
    //关闭修改弹出层
    function open1() {
        document.getElementById("div").style.display="none";
    }
    //退出登录
    $("#tui").click(function () {
        $.ajax({
            url:"<?php echo url('/tui') ?>",
            success:function (res) {
                window.location.href="<?php echo url('/login');?>";
            }
        })
    })


</script>
