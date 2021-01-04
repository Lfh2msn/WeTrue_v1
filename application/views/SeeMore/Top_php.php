<div class="media">
    <img width="42" height="42" src="<?php echo $portrait;?>" class="d-block rounded">
    <div class="media-body ml-2">
        <a href="/Wallet/ID/<?php echo $sender_id;?>">
        <button class="border-0 btn-transition btn btn-outline-success"><?php echo $username;?>
        <span class="text-muted small">ID:<?php echo $sender_id_show;?></span></button>
        </a>
        <?php echo $uactive;?>
        <div class="text-muted small" id="utctime"><?php echo $utctime;?></div>
    </div>
</div>