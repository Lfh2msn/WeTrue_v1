<div class="media mt-2">
    <img width="42" height="42" src="<?php echo $portrait;?>" class="d-block rounded">
    <div class="media-body ml-1">
        <a class="widget-numbers text-success" href="/Wallet/ID/<?php echo $sender_id;?>">
        <?php echo $username;?>
        <span class="text-muted small">ID:<?php echo $sender_id_show;?></span>
        </a>
        <?php echo $uactive;?>
        <div class="text-muted small" id="utctime"><?php echo $utctime;?></div>
    </div>
</div>