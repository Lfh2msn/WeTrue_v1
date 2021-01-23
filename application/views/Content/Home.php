
    <div class="app-main__inner">
        <div class="card mb-3">
            <div class="card-body">
                <?php $this->load->view('SeeMore/Top_php');?>
                    <textarea class="form-control-plaintext text_ZeroFrame autosize-input" readonly><?php echo $payload;?></textarea>
                    <?php echo $imgtx;?>
            </div>
            <?php $this->load->view('SeeMore/Php_Conn');?>
    </div>
    <div class="card mb-1">
        <button class="card-body btn btn-dashed btn-outline-focus disabled" i18n="LatestReply">最新评论</button>
        <?php $this->load->view('List_box');?>
    </div>

<?php $this->load->view('footer_inside');?>
<?php $this->load->view('footer');?>

<script>
var pageNum = 1;
var max_page = 0;
var pageLimit = 10;
var Conenthash = '<?php echo $hash ?>';
autoScroll();

function get_content(){
    var str = '';
        $.post("/Comment/GetComment/",{'pageNum':pageNum,'pageLimit':pageLimit,'hash':Conenthash},
            function(jitem){
                $('#getMore').hide();
                item = $.parseJSON(jitem);
                max_page = parseInt(item[0].totalPage);
                pageNum = parseInt(item[0].pageNum);
                for(i in item){
                var appdurl =`<a href="/Comment/Tx/${item[i].hash}">`;
                str +=  `<div class="card mb-1">
                <div class="card-body">
                    <?php $this->load->view('SeeMore/Top_Js');?>
                            ${item[i].commsum>0?appdurl:""}
                        <textarea class="form-control-plaintext text_ZeroFrame autosize-input scrollbar-container" readonly>${item[i].payload}</textarea>
                            </a>
                </div>
                <?php $this->load->view('SeeMore/Js_Comm');?>
            </div>`;
            
        }
        PostLoad(str);
    });
}
document.getElementById('getContentEnd').innerHTML = '--- END ---';
document.getElementById("utctime").innerHTML = stampToTime(<?php echo $utctime;?>);
</script>