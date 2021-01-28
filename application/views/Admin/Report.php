 <div class="app-main__inner">
    <div id="list_box"></div>
    <div id="getMore" class="getContent">正在加载...</div>
    <div class="getContentEnd">-- END --</div>

<?php $this->load->view('Admin/footer');?>

<script>
var pageNum = 1;
var max_page = 0;
var pageLimit = 10;
autoScroll();

function get_content(){
    var str = '';
    $.post("/Admin/Report/GetReport/",{'pageNum':pageNum,'pageLimit':pageLimit},
    function(jitem){
        $('#getMore').hide();
        item = $.parseJSON(jitem);
        max_page = parseInt(item[0].totalPage);
        pageNum = parseInt(item[0].pageNum);
        for(i in item){
            var addImg =`<div class="autoimg_div imgLoading"><img class="autoimg_img clickMaxImg" src="/assets/images/wet-loading.jpg" data-src="/Tools/hashToimg/${item[i].imgtx}"></div>`;
            str +=  `<div class="card mb-3">
                        <div class="card-body">
                            <?php $this->load->view('SeeMore/Js_Content_Top');?>
                                    <a href="/Content/Tx/${item[i].hash}">
                                        <textarea class="form-control-plaintext text_ZeroFrame autosize-input scrollbar-container ps--active-y" style="max-height:110px;" readonly>${item[i].payload}</textarea>

                                    </a>
                                    ${item[i].imgtx!=""?addImg:""}
                        </div>
                    <?php $this->load->view('Admin/SeeMore/Js_Content_footer');?>
                </div>`;
            
        }
        pageNum++;
        $("#list_box").append(str);
        // 一开始没有滚动的时候,出现在视窗中的图片也会加载
        imgloadingStart();
        autosize($('.autosize-input'));
    });
}
</script>