				<div class="app-main__inner">
                    
                    	<div class="container">
                            <ul class="tabs-animated-shadow tabs-animated nav nav-justified tabs-rounded-lg">
							    <li class="nav-item">
							        <a class="nav-link active" href="javascript:void(0);" onclick="return set_durl('conn');">
							            <span><n i18n="Search">搜索</n><n i18n="Content">主帖</n></span>
							        </a>
							    </li>
							    <li class="nav-item">
							        <a class="nav-link" href="javascript:void(0);" onclick="return set_durl('comm');">
							            <span><n i18n="Search">搜索</n><n i18n="Comment">评论</span>
							        </a>
							    </li>
							    <li class="nav-item">
							        <a class="nav-link" href="javascript:void(0);" onclick="return set_durl('user');">
							           <span><n i18n="Search">搜索</n><n i18n="Account">账户</span>
							        </a>
							    </li>
							</ul>
                        </div>

  
<?php $this->load->view('List_box');?>
<?php $this->load->view('footer_inside');?>
<?php $this->load->view('footer');?>
        </div>
    </div>

<script language="javascript">
new ClipboardJS('.btn');
var pageNum = 1;
var max_page = 0;
var pageLimit = 10;
var lastpangenum;
var KeyWord = '<?php echo $KeyWord ?>';
set_durl();
autoScroll();

function set_durl(attribute){
	if(attribute == "comm"){
		Search_url = "/Search/Comment/";
		ConnDoComm = 'Comment';
		Follow_Types = 'Comment';
		document.getElementById("list_box").innerHTML = "";
		get_content(1);
	}else if(attribute == "user"){
		Search_url = "/Search/User/";
		Follow_Types = 'User';
		document.getElementById("list_box").innerHTML = "";
		get_content(1);
	}else{
		Search_url = "/Search/Content/";
		ConnDoComm = 'Content';
		Follow_Types = 'Content';
		document.getElementById("list_box").innerHTML = "";
		get_content(1);
	}

}

function get_content(dstr){
    var str = '';
    if(dstr=='1'){
    	pageNum = 1;
    	lastpangenum = -1;
    }

    if (pageNum != lastpangenum) {
		$.post(Search_url,{'pageNum':pageNum,'pageLimit':pageLimit,'KeyWord':KeyWord},
        function(jitem){
            $('#getMore').hide();
            item = $.parseJSON(jitem);
            max_page = parseInt(item[0].totalPage);
            pageNum = parseInt(item[0].pageNum);
            if(Follow_Types != 'User'){
            for(i in item){
                var addImg =`<div class="autoimg_div imgLoading"><img class="autoimg_img clickMaxImg" src="/assets/images/wet-loading.jpg" data-src="/Tools/hashToimg/${item[i].imgtx}"></div>`;
	            str +=  `<div class="card mb-2">
	                        <div class="card-body">
	                            <?php $this->load->view('SeeMore/Top_Js');?>
	                                <a href="/${Follow_Types!="Content"?"Comment":"Content"}/Tx/${item[i].hash}">
	                                    <textarea class="form-control-plaintext text_ZeroFrame autosize-input" style="max-height:125px;" readonly>${item[i].payload}</textarea>
	                                </a>
	                            ${item[i].imgtx!=""?addImg:""}
	                        </div>
	                    <?php $this->load->view('SeeMore/Js_Conn');?>
	                </div>`;
            }
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
                            	<img width="40" height="40" class="rounded-circle" src="${item[i].portrait}">
                            </td>
                            <td>
                                <div class="widget-content p-0">
                                    <div class="widget-content-wrapper">
                                        <div class="widget-content-left flex2">
                                            <div class="widget-heading">${item[i].username}</div>
                                            <div class="widget-subheading">${item[i].UserId_show}</div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="text-center">
                                ${item[i].uactive}
                            </td>
                            <td class="text-center">
                                ${item[i].active}
                            </td>
                            <td class="text-center">
                                <a href="/Wallet/ID/${item[i].UserId}">前往</a>
                            </td></tr>`;
        	}
        		str +=`</tbody></table></div></div></div></div>`
        }
            PostLoad(str);
        });
lastpangenum = pageNum;
    }
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

</script>