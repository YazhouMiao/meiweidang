<div class="box">
  <?php if (isset($heading_title)) { ?>
	  <div class="box-heading"><?php echo $heading_title; ?></div>
	  <div class="box-content" style="text-align: center;">
		<?php echo $qr_code; ?>
	  </div>
	  <div class="bottom">&nbsp;</div>
  <?php }else{ 
	echo $qr_code;
  } ?>
</div>

