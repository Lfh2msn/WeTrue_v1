<div class="media mt-2">
    <img width="42" height="42" src="<?php echo $users['portrait'];?>" class="d-block rounded">
    <div class="media-body ml-1">
        <a class="widget-numbers text-success" href="/Wallet/ID/<?php echo $sender_id;?>">
        <?php echo $users['username'];?>
        </a>
        <?php echo $users['uactive'];?>
        <div class="text-muted small" id="utctime"><?php echo $utctime;?></div>
    </div>
	<div class="text-muted small">
		<a class="widget-numbers text-success" href="/Wallet/ID/<?php echo $sender_id;?>">
		<div><span class="text-muted small">ID:<?php echo $sender_id_show;?></span></div>
	</a>
	</div>
</div>