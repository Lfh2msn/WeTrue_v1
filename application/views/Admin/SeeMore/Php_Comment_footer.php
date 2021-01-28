<div class="card-footer d-flex flex-wrap justify-content-between px-0 pt-0 pb-0">
	<div class="px-4 pt-0">
        <span class="text-muted d-inline-flex align-items-center align-middle">
            <i class="CommentLove metismenu-icon far fa-heart" id="<?php echo $txhash;?>">&nbsp;<?php echo $love;?></i>
        </span>
        <span class="text-muted d-inline-flex align-items-center align-middle ml-5">
            <i class="far fa-comments">&nbsp;<?php echo $commsum;?></i>
        </span>
    </div>
    <div class="px-4 pt-1">
        <div class="d-inline-block dropdown">
            <button type="button" aria-haspopup="true" aria-expanded="false" data-toggle="dropdown" 
            class="badge mb-1 mr-1 btn btn-dashed btn-outline-light">
                <i class="btn-icon-wrapper"></i>&nbsp;<n i18n="More">查看</n>
            </button>
            <div tabindex="-1" role="menu" aria-hidden="true" class="dropdown-menu dropdown-menu-right">
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a href="https://www.aeknow.org/miner/viewaccount/<?php echo $txhash;?>" target="_blank" class="nav-link">
                            <i class="nav-link-icon"></i><span>AEKnow</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="https://mainnet.aeternal.io/transactions/<?php echo $txhash;?>" target="_blank" class="nav-link">
                            <i class="nav-link-icon"></i><span>Aeternal</span>
                        </a>
                    </li>
                    <li class="nav-item AdminUnReport" id="<?php echo $sender_id;?>" hash="<?php echo $txhash;?>">
                        <a class="nav-link">
                            <i class="nav-link-icon"></i><span>取消举报\屏蔽</span>
                        </a>
                    </li>
                    <li class="nav-item AdminReport" id="<?php echo $sender_id;?>" hash="<?php echo $txhash;?>">
                        <a class="nav-link">
                            <i class="nav-link-icon"></i><span>举报</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>