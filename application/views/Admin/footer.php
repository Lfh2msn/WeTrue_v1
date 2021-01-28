    </div>
	</div>
</div>
<div id="WETConfig" WeTrue="<?php echo $WeTrue?>" toConAmount="<?php echo $toConAmount?>" toComAmount="<?php echo $toComAmount?>" toNameAmount = "<?php echo $toNameAmount?>" toRecid = "<?php echo $toRecid?>" toSendNode = "<?php echo $toSendNode?>" toPortraitAmount = "<?php echo $toPortraitAmount?>"></div>
<div class="app-drawer-overlay d-none animated fadeIn"></div>
    <script type="text/javascript" src="/assets/scripts/F_Tips_C.js?v=0.5.2"></script>
	<script type="text/javascript" src="/assets/scripts/main.js?v=1.0.1"></script>
	<script type="text/javascript" src="/assets/scripts/script.js?v=0.5.3"></script>
    <script src="/assets/scripts/WeTrue-sdk.js?v=<?php echo $WeTrue?>"></script>
    <script src="/assets/scripts/wet-img.js?v=1.0.1"></script>
</body>
</html>
<script>
//屏蔽
$(document).on("click",".AdminReport",function(){
    const lols = window.localStorage;
    const informant = lols["publicKey"];
    const report = $(this);
    const rp_sender_id = report.attr("id");
    const rp_hash = report.attr("hash");
    if(informant==null || informant=="" || informant=='undefined'){
        $.toast("未登录",2);//显示提示
        return false;
    }
    $.toast("屏蔽中...",5);//显示提示
    $.ajax({
        type:"POST",
        url:"/Admin/Report/Admin_Report",
        data:{rp_hash,rp_sender_id,informant},
        cache:false, //不缓存此页面
        success:function(data){
            $.removetoast(); //关闭等待
            $.toast(data,1);//显示提示
        },error:function(e){
            $.removetoast(); //关闭等待
            $.toast(e.status+" "+e.statusText,2);//显示提示
        }
    });
    return false;
});

//取消屏蔽
$(document).on("click",".AdminUnReport",function(){
    const lols = window.localStorage;
    const informant = lols["publicKey"];
    const report = $(this);
    const rp_sender_id = report.attr("id");
    const rp_hash = report.attr("hash");
    if(informant==null || informant=="" || informant=='undefined'){
        $.toast("未登录",2);//显示提示
        return false;
    }
    $.toast("取消中...",5);//显示提示
    $.ajax({
        type:"POST",
        url:"/Admin/Report/Admin_UnReport",
        data:{rp_hash,rp_sender_id,informant},
        cache:false, //不缓存此页面
        success:function(data){
            $.removetoast(); //关闭等待
            $.toast(data,1);//显示提示
        },error:function(e){
            $.removetoast(); //关闭等待
            $.toast(e.status+" "+e.statusText,2);//显示提示
        }
    });
    return false;
});
</script>