<div class="card-footer d-flex flex-wrap justify-content-between px-0 pt-0 pb-0">
    <div class="px-4 pt-0">
        <span class="text-muted d-inline-flex align-items-center align-middle">
        <i class="love metismenu-icon pe-7s-like pe-2x pe-va" id="<?php echo $txhash;?>"><span style="font-size:15px"><?php echo $love;?></span></i>
        </span>
        <span class="text-muted d-inline-flex align-items-center align-middle ml-5">
            <a href="/Comment/Post/<?php echo $txhash;?>" class="text-muted d-inline-flex align-items-center align-middle" id="logoutcommsum">
            <i class="metismenu-icon pe-7s-comment pe-2x pe-va"></i>&nbsp;
            <span class="align-middle"><?php echo $commsum;?></span>
        </span></a>
    </div>
    <div class="px-4 pt-1">
        <div class="d-inline-block dropdown">
            <button type="button" aria-haspopup="true" aria-expanded="false" data-toggle="dropdown" 
            class="badge mb-1 mr-1 btn btn-dashed btn-outline-light">
                <i class="pe-7s-more btn-icon-wrapper"></i>&nbsp;查看
            </button>
            <div tabindex="-1" role="menu" aria-hidden="true" class="dropdown-menu dropdown-menu-right">
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a href="https://www.aeknow.org/miner/viewaccount/<?php echo $txhash;?>" target="_blank" class="nav-link">
                            <i class="nav-link-icon pe-7s-network"></i><span>AEKnow</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="https://mainnet.aeternal.io/transactions/<?php echo $txhash;?>" target="_blank" class="nav-link">
                            <i class="nav-link-icon pe-7s-network"></i><span>Aeternal</span>
                        </a>
                    </li>
                    <li class="nav-item AdminUnReport" id="<?php echo $sender_id;?>" hash="<?php echo $txhash;?>">
                        <a class="nav-link">
                            <i class="nav-link-icon pe-7s-door-lock"></i><span>取消举报\屏蔽</span>
                        </a>
                    </li>
                    <li class="nav-item AdminReport" id="<?php echo $sender_id;?>" hash="<?php echo $txhash;?>">
                        <a class="nav-link">
                            <i class="nav-link-icon pe-7s-door-lock"></i><span>举报</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>