<div class="app-main__inner">
	<div class="card mb-3" >
        <div class="card-body">
        	<div class="row" id="list_box">

			</div>
		</div>
	</div>

<div id="getMore" class="getContent"> Loading... </div>
<div id="getContentEnd" class="getContentEnd"> Loading... </div>

<?php $this->load->view('footer'); ?>

<script>
var pageNum = 1;
var max_page = 0;
var pageLimit = 15;
var lastpangenum;
autoScroll();

function get_content(){
    var str = '';
    if (pageNum != lastpangenum) {
        $.post("/LatestPictures/Content/",{'pageNum':pageNum,'pageLimit':pageLimit},
        function(jitem){
            item = $.parseJSON(jitem);
            max_page = parseInt(item[0].totalPage);
            pageNum = parseInt(item[0].pageNum);
            for(i in item){
            	const addImg =`<div class="autoLatest_div imgLoading col-md-3 mt-3"><img class="autoLatest_img clickMaxImg" src="/assets/images/wet-loading.jpg" data-src="/Tools/hashToimg/${item[i].imgtx}"></div>`;
                str +=  `${item[i].imgtx!=""?addImg:""}`;
            }
            PostLoad(str);
            with($('.autoLatest_div')){
                css('width',$(document).width()*0.288);
                css('height',$(document).width()*0.288);
            }
        });
    lastpangenum = pageNum;
    }
}
</script>