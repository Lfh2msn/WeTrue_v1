				<div class="app-main__inner">
                    <div class="app-inner-layout">
                        <div class="app-inner-layout__header-boxed p-0">
                            <div id="topuserid" class="app-inner-layout__header text-white bg-premium-dark mb-3">
                                
                                <div>
                                    <img class="clickMaxImg" width="70" height="70" src="/Tools/Aktoimg/<?php echo $sendid_id ?>">
                                    <div class="btn-group ml-3">
                                        <textarea class="alert-info text_BandFrame" rows="3" placeholder="ak_****XXXX" onclick="this.select();" id="User_WalletID" readonly><?php echo $sendid_id ?></textarea>
                                    </div>
                                    <button type="button" data-clipboard-target="#User_WalletID" class="btn-shadow btn-pill btn-wide btn btn-outline-alternate mt-2 ml-3" i18n="Copy">复制钱包地址</button>
                                </div>

                            </div>
                        </div>
                    </div>
					<div class="card-header">
						<ul class="nav nav-justified">
							<li class="nav-item">
								<a class="nav-link active" href="javascript:void(0);" onclick="return set_durl('conn');">
									<i class="d-none d-md-block fa fa-comment-o"></i>
									<div class="widget-number"><span i18n="Content">主帖</span></div>
								</a>
							</li>
							<li class="nav-item">
								<a class="nav-link" href="javascript:void(0);" onclick="return set_durl('comm');">
									<i class="d-none d-md-block fa fa-comments-o"></i>
									<div class="widget-number"><span i18n="Comment">评论</span></div>
								</a>
							</li>
							<li class="nav-item">
								<a class="nav-link" href="javascript:void(0);" onclick="return set_durl('wing');">
									<i class="d-none d-md-block fa fa-user"></i>
									<div class="widget-number"><span i18n="Following">关注</span></div>
								</a>
							</li>
							<li class="nav-item">
								<a class="nav-link" href="javascript:void(0);" onclick="return set_durl('wers');">
									<i class="d-none d-md-block fa fa-users"></i>
									<div class="widget-number"><span i18n="Followers">被关注</span></div>
								</a>
							</li>
						</ul>
					</div>
					
<?php $this->load->view('List_box');?>
<?php $this->load->view('footer');?>
        </div>
    </div>

<script language="javascript">
new ClipboardJS('.btn');
var pageNum = 1;
var max_page = 0;
var pageLimit = 10;
var lastpangenum;
var sendid_id = '<?php echo $sendid_id ?>';
set_durl();
autoScroll();

function set_durl(attribute){
	if(attribute == "comm"){
		Wallet_url = "/Wallet/Comment/";
		ConnDoComm = 'Comment';
		Follow_Types = 'Content';
		document.getElementById("list_box").innerHTML = "";
		get_content(1);
		TokenCall();
	}else if(attribute == "wing"){
		Wallet_url = "/Wallet/Following/";
		Follow_Types = 'Follow';
		document.getElementById("list_box").innerHTML = "";
		get_content(1);
	}else if(attribute == "wers"){
		Wallet_url = "/Wallet/Followers/";
		Follow_Types = 'Follow';
		document.getElementById("list_box").innerHTML = "";
		get_content(1);
	}else{
		Wallet_url = "/Wallet/Content/";
		ConnDoComm = 'Content';
		Follow_Types = 'Content';
		document.getElementById("list_box").innerHTML = "";
		get_content(1);
		TokenCall();
	}

}

function get_content(dstr){
    var str = '';
    if(dstr=='1'){
    	pageNum = 1;
    	lastpangenum = -1;
    }
    if (pageNum != lastpangenum) {
        $.post(Wallet_url,{'pageNum':pageNum,'pageLimit':pageLimit,'sendid_id':sendid_id},
        function(jitem){
            $('#getMore').hide();
            item = $.parseJSON(jitem);
            max_page = parseInt(item[0].totalPage);
            pageNum = parseInt(item[0].pageNum);
            if(Follow_Types != 'Follow'){
            document.getElementById("topuserid").innerHTML = `
                				<div class="app-page-title mb-3">
                                    <div class="page-title-wrapper">
                                        <div class="page-title-heading">
                                        	<img width="90" height="90" src="${item[0].users.portrait}">
                                            <div class="btn-group">
                                                <div class="ml-1">${item[0].users.username} ${item[0].users.uactive}
													<div class="page-title-subheading"><n i18n="Active">活跃度</n> : 
													${item[0].users.active}
													</div>
													<div class="page-title-subheading">
														WTT : <n class="token"></n>
														<br>待入账WTT : ${item[0].users.lastActive}
													</div>
												</div>
                                                <div class="page-title-actions ml-5">
            										<button title="Example Tooltip" class="btn btn-secondary Following">
													<i class="fa fa-star"></i>
													</button>
												</div>
                                            </div>
                                        </div>
    									</div>
                        		</div>
                                <div class="app-page-title">
                                    <div class="page-title-wrapper">
                                		<div>
                                        	<img class="clickMaxImg" width="80" height="80" src="/Tools/Aktoimg/${sendid_id}">
                                            <div class="btn-group ml-3">
                                                <textarea class="alert-info text_BandFrame" rows="3" placeholder="ak_****XXXX" onclick="this.select();" id="User_WalletID" readonly>${sendid_id}</textarea>
                                            </div>
                                        </div>
                                        <button type="button" data-clipboard-target="#User_WalletID" class="btn-shadow btn-pill btn-wide btn btn-outline-alternate ml-3" i18n="Copy">复制</button>
    								</div>
                                </div>`;
			str +=`<div class="main-card mb-3 card"><div class="card-body"><div class="vertical-time-simple vertical-without-time vertical-timeline vertical-timeline--animate vertical-timeline--one-column">`
            for(i in item){
                var addImg =`<div class="autoimg_div imgLoading"><img class="autoimg_img clickMaxImg" src="/assets/images/wet-loading.jpg" data-src="/Tools/hashToimg/${item[i].imgtx}"></div>`;
                str += `<div class="vertical-timeline-item vertical-timeline-element dot-primary">
						<div>
							<span class="vertical-timeline-element-icon bounce-in"></span>
							<div class="vertical-timeline-element-content bounce-in">
							<h4 class="timeline-title">${stampToTime(item[i].utctime)}</h4>
							<a href="/${ConnDoComm}/Tx/${item[i].hash}">
							<textarea class="form-control-plaintext text_ZeroFrame autosize-input" style="max-height:125px;" readonly>${item[i].payload}</textarea>
                            </a>
                            ${item[i].imgtx!=""?addImg:""}
							</div>
						</div>
					</div>`;
            }
			str +=`</div></div></div>`
        }else{
        		str = `<div class="row">
                    <div class="col-md-12">
                        <div class="main-card mb-3 card">
                            <div class="table-responsive">
                                <table class="align-middle mb-0 table table-borderless table-striped table-hover">
                                    <thead>
                                    <tr>
                                        <th class="text-center">头像</th>
                                        <th>昵称</th>
                                        <th class="text-center">等级</th>
                                        <th class="text-center" i18n="Active">活跃度</th>
                                        <th class="text-center">查看</th>
                                    </tr>
                                    </thead>
                                    <tbody>`;
            for(i in item){
                str +=` <tr><td class="text-center">
                            	<img width="40" height="40" class="rounded-circle" src="${item[i].users.portrait}">
                            </td>
                            <td>
                                <div class="widget-content p-0">
                                    <div class="widget-content-wrapper">
                                        <div class="widget-content-left flex2">
                                            <div class="widget-heading">${item[i].users.username}</div>
                                            <div class="widget-subheading">${item[i].follow_show}</div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="text-center">
                                ${item[i].users.uactive}
                            </td>
                            <td class="text-center">
                                ${item[i].users.active}
                            </td>
                            <td class="text-center">
                                <a href="/Wallet/ID/${item[i].follow}">前往</a>
                            </td></tr>`;
        	}
        		str +=`</tbody></table></div></div></div></div>`
        }
            PostLoad(str);
        });
lastpangenum = pageNum;
    }
}

async function TokenCall(){
	var aeknowUrl = 'https://www.aeknow.org/api/token/' + sendid_id;
	$.get(aeknowUrl,function(data){
		const json = $.parseJSON(data);
		const tokens = json.tokens;
		for(i in tokens){
			if (tokens[i].tokenname == 'WTT'){
				const token = tokens[i].balance;
				const tokenBalance = balanceDC(token);
				 $('.token').html(tokenBalance);
			}
		}
	});
}

function autoScrolla(){

    function scrollTop(){
        return Math.max(
            window.pageYOffset,
            document.body.scrollTop,
            document.documentElement.scrollTop);
    }

    function documentHeight(){
        return Math.max(document.body.scrollHeight,document.documentElement.scrollHeight);
    }

    function windowHeight(){
         return (document.compatMode == "CSS1Compat")?
         document.documentElement.clientHeight:
         document.body.clientHeight;
    }
    
    $(window).scroll(function(){
        if((scrollTop() + windowHeight()) - documentHeight() >= -100 && pageNum <= max_page){
            $('#getMore').show();
            setTimeout(function(){
                get_content(0);
            },300);
        }
    });
}

$(document).on("click", ".nav-link", function() {
	$(".nav-link").removeClass("active");
	$(this).addClass("active");
});

$(document).on("click",".Following",function(){
    const loadls = window.localStorage;
    const wers_id = loadls["publicKey"];
    const wing_id = '<?php echo $sendid_id ?>';
    if(wers_id==null || wers_id=="" || wers_id=='undefined'){
        $.toast("未登录",2);
        return false;
    }
    $.toast("关注中",5);
    $.ajax({
        type:"GET",
        url:"/Wallet/Follow/",
        data:{wing_id,wers_id},
        cache:false,
        success:function(data){
            $.removetoast();
            $.toast(data,1);
        },error:function(e){
            $.removetoast();
            $.toast(e.status+" "+e.statusText,2);
        }
    });
    return false;
});

</script>