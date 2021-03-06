 <div class="app-main__inner">

<div class="main-card mb-3 card">
	<div class="card-body">
		<h5 class="card-title">生成 &amp; WTT列表</h5>
		<div class="form-check form-check-inline">
			<input id="inlineCheckbox" type="checkbox">
			<label class="form-check-label">清空WTT列表</label>
		</div>
	</div>
	<button class="btn btn-primary btn-lg" onclick="return getList();">更新</button>
</div>
		
	<div ></div>

    <div class="col-lg-12">
        <div class="main-card mb-3 card">
            <div class="card-body"><h5 class="card-title">列表</h5>
                <table class="mb-0 table table-striped">
                    <thead>
                    <tr>
                        <th>hash</th>
                        <th>:</th>
                        <th>number</th>
                    </tr>
                    </thead>
                    <tbody id="list_box">
                    </tbody>
                </table>
            </div>
        </div>
    </div>

<?php $this->load->view('Admin/footer');?>

<script>

//获取列表
function getList(){
	if($("#inlineCheckbox").prop("checked")==true){
		var checked = '/Empty';
	}else{
		var checked = '';
	}
    const lols = window.localStorage;
    const adminId = lols["publicKey"];
    const report = $(this);
    const rp_sender_id = report.attr("id");
    const rp_hash = report.attr("hash");
    if(adminId==null || adminId=="" || adminId=='undefined'){
        $.toast("未登录",2);
        return false;
    }
    $.toast("提交中...",3);
    $.ajax({
        type:"POST",
        url:"/Admin/Airdrop/ActivateAirdrop" + checked,
        data:{adminId},
        cache:false,
        success:function(data){
			$("#list_box").html("");
            $.removetoast(); //关闭等待
            $("#list_box").append(data);
        },error:function(e){
            $.removetoast();
            $.toast(e.status+" "+e.statusText,2);//显示提示
        }
    });
    return false;
};
</script>