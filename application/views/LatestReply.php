 <div class="app-main__inner">


<?php $this->load->view('List_box');?>
<?php $this->load->view('footer'); ?>

<script>
var pageNum = 1;
var max_page = 0;
var pageLimit = 10;
var lastpangenum;
autoScroll();

function get_content(){
    var str = '';
    if (pageNum != lastpangenum) {
        $.post("/LatestReply/Content/",{'pageNum':pageNum,'pageLimit':pageLimit,'sort':'Comment'},
        function(jitem){
            item = $.parseJSON(jitem);
            max_page = parseInt(item[0].totalPage);
            pageNum = parseInt(item[0].pageNum);
            for(i in item){
                str +=  `<div class="card mb-1" >
                        <div class="card-body">
                            <?php $this->load->view('SeeMore/Top_Js');?>
                                    <a href="/Comment/Tx/${item[i].hash}">
                                        <textarea class="form-control-plaintext text_ZeroFrame autosize-input" style="max-height:110px;" readonly>${item[i].payload}</textarea>
                                    </a>
									Reply To: <a href="/Content/Tx/${item[i].to_hash}">${item[i].to_hash.substring(0, 9)+"****"+item[i].to_hash.substr(-14)}</a>
                        </div>
                        	<?php $this->load->view('SeeMore/Js_Comm');?>
                    </div>`;
                
            }
            PostLoad(str);
        });
lastpangenum = pageNum;
    }
}

</script>