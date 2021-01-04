    </div>
	</div>
</div>
<div class="app-drawer-overlay d-none animated fadeIn"></div>

<div id="onAddress" class="white_content">
    <img id="onAddressImg" style="with:140px;" src="">
<div class="position-relative form-group">
    <textarea id="onAddressText" rows="1" class="form-control alert alert-info " style="height: 200px;" 
    onclick="this.select();" readonly="readonly"></textarea>
    </div>

<a href = "javascript:void(0)" class="btn btn-danger" onclick = "onAddress('off')">关闭</a>
</div> 
<div id="onBlackAddress" class="black_overlay"></div>
    <script type="text/javascript" src="/assets/scripts/F_Tips_C.js?<?php echo $WeTrue?>"></script>
	<script type="text/javascript" src="/assets/scripts/main.js?<?php echo $WeTrue?>"></script>
	<script type="text/javascript" src="/assets/scripts/script.js?<?php echo $WeTrue?>"></script>
    <script src="/assets/scripts/WeTrue-sdk.js?<?php echo $WeTrue?>"></script>
    <script src="/assets/scripts/wet-img.js?<?php echo $WeTrue?>"></script>
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