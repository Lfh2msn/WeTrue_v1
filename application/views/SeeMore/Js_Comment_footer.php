<div class="d-flex flex-wrap justify-content-between">
    <div class="px-1">
        <span class="text-muted d-inline-flex align-items-center align-middle">
            <i class="CommentLove metismenu-icon far fa-heart" id="${item[i].hash}">&nbsp;${item[i].love}</i>
        </span>
        <span class="text-muted d-inline-flex align-items-center align-middle ml-5">
            <a href="/Comment/Post/${item[i].hash}" class="text-muted d-inline-flex align-items-center align-middle" id="logoutcommsum">
            <i class="far fa-comments">&nbsp;${item[i].commsum}</i>
        </span></a>
    </div>
    <div class="px-1">
        <div class="dropdown d-inline-block">
            <button type="button" aria-haspopup="true" aria-expanded="false" data-toggle="dropdown" 
            class="badge btn btn-dashed btn-outline-light mb-1">
            <n i18n="More">查看</n>
            </button>
            <div tabindex="-1" role="menu" aria-hidden="true" class="dropdown-menu dropdown-menu-right">
                <ul class="nav flex-column">
                	<li class="nav-item report" id="${item[i].sender_id}" hash="${item[i].hash}">
                        <a class="nav-link">
                            <i class="nav-link-icon pe-7s-door-lock"></i><span i18n="Report">举报</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="https://mainnet.aeternal.io/transactions/${item[i].hash}" target="_blank" rel="noopener noreferrer" class="nav-link">
                            <i class="nav-link-icon pe-7s-network"></i><span>Aeternal</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="https://www.aeknow.org/miner/viewaccount/${item[i].hash}" target="_blank" rel="noopener noreferrer" class="nav-link">
                            <i class="nav-link-icon pe-7s-network"></i><span>AEKnow</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
<hr style="margin:0px;height:1px;border:0px;background-color:#D5D5D5;color:#D5D5D5;"/>