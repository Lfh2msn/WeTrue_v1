<div class="app-main__inner">
<div class="card mb-1" >
    <div class="card-body">
<div id="list_box"></div>
 
<div id="getMore" class="getContent">正在加载...</div>
<div class="getContentEnd">-- END --</div>

<?php $this->load->view('Admin/footer'); ?>

<script>
var pageNum = 1;
var max_page = 0;
var pageLimit = 10;
autoScroll();

function get_content(){
    var str = '';
    $.post("LatestReply/Content/",{'pageNum':pageNum,'pageLimit':pageLimit,'sort':'Comment'},
    function(jitem){
        $('#getMore').hide();
        item = $.parseJSON(jitem);
        max_page = parseInt(item[0].totalPage);
        pageNum = parseInt(item[0].pageNum);
        for(i in item){
            str +=  `<?php $this->load->view('SeeMore/Js_Content_Top');?>
					<a class="text-muted small" href="/Content/Tx/${item[i].to_hash}">Reply: ${item[i].to_hash.substring(0, 5)+"***"+item[i].to_hash.substr(-5)}</a>
                                    <a href="/Comment/Tx/${item[i].hash}">
                                        <textarea class="form-control-plaintext text_ZeroFrame autosize-input" style="max-height:110px;" readonly>${item[i].payload}</textarea>
                                    </a>
									
                        </div>
                    	<?php $this->load->view('Admin/SeeMore/Js_Comment_footer');?>
                </div>`;
            
        }
        pageNum++;
        $("#list_box").append(str);
        imgloadingStart();
        autosize($('.autosize-input'));
    });
}
</script>