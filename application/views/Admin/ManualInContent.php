<div class="app-main__inner">
	


        <div class="form-row">
            <div class="col-md-6">
                <span id="Tips">提交主帖hash</span>
                <div class="position-relative form-group">
                	<input name="hash" id="hash" placeholder="提交hash" type="UserName" class="form-control" AUTOCOMPLETE="off">
                    <button class="btn btn-primary btn-lg" onclick="return Manual_In();">提交</button>
                </div>
            </div>
        </div>
    
     <div class="col-lg-12">
        <div class="main-card mb-3 card">
            <div class="card-body"><h5 class="card-title">失败列表</h5>
                <table class="mb-0 table table-striped">
                    <thead>
                    <tr>
                        <th>uid</th>
                        <th>tp_hash</th>
                        <th>tp_source</th>
                        <th>tp_time</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php echo $tpContent;?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>


<?php $this->load->view('Admin/footer');?>

<script>
function Manual_In(){
	const hash = document.getElementById('hash').value;
    console.log(hash)
    const url = "/Admin/ManualIn/InContent/" + hash;
	const jqxhr = $.get(url, callback);
	jqxhr.fail(function(xhr, error, throwerror) {
		$("#Tips").html("error:" + xhr.status);
	});
}

//ajax的回调函数
	function callback(data, status) {
		$("#Tips").html(data);
	}

</script>