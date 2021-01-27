 <div class="app-main__inner">

<?php $this->load->view('List_box');?>
<?php $this->load->view('footer');?>

<script>
var pageNum = 1;
var max_page = 0;
var pageLimit = 10;
var lastpangenum;
autoScroll();
get_content()

function get_content(){
    var str = '';
    if (pageNum != lastpangenum) {
	    $.post("/HotPosts/Content/",{'pageNum':pageNum,'pageLimit':pageLimit},
	    function(jitem){
	        item = $.parseJSON(jitem);
	        max_page = parseInt(item[0].totalPage);
	        pageNum = parseInt(item[0].pageNum);
	        for(i in item){
	            var addImg =`<div class="autoimg_div imgLoading"><img class="autoimg_img clickMaxImg" src="/assets/images/wet-loading.jpg" data-src="/Tools/hashToimg/${item[i].imgtx}"></div>`;
	            str +=  `<div class="card mb-1">
	                        <div class="card-body">
	                            <?php $this->load->view('SeeMore/Js_Content_Top');?>
	                                <a href="/Content/Tx/${item[i].hash}">
	                                    <textarea class="form-control-plaintext text_ZeroFrame autosize-input" style="max-height:125px;" readonly>${item[i].payload}</textarea>
	                                </a>
	                            ${item[i].imgtx!=""?addImg:""}
	                        </div>
	                    <?php $this->load->view('SeeMore/Js_Content_footer');?>
	                </div>`;
	            
	        }
	        PostLoad(str);
	    });
    lastpangenum = pageNum;
	}
}

</script>