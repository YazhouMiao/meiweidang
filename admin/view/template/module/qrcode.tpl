
<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <button type="submit" form="form-qrcode" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
        <a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="<?php echo $button_cancel; ?>" class="btn btn-default"><i class="fa fa-reply"></i></a></div>
      <h1><?php echo $heading_title; ?></h1>
      
      <ul class="breadcrumb">
        <?php foreach ($breadcrumbs as $breadcrumb) { ?>
        <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
        <?php } ?>
      </ul>
      
    </div>
  </div>
  <div class="container-fluid">
    <?php if (isset($error_warning)) { ?>
    <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?>
      <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
    <?php } ?> 
	    
    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $text_edit; ?></h3>
      </div>
      <div class="panel-body">
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-qrcode" class="form-horizontal">
        <div class="form-group">
            <label class="col-sm-2 control-label" for="input-size"><?php echo $entry_size; ?></label>
            <div class="col-sm-10">
              <input type="text" name="qrcode_size" value="<?php echo $qrcode_size; ?>" id="input-size" class="form-control" />
              <?php if (isset($error_size)) { ?>
              <div class="text-danger"><?php echo $error_size; ?></div>
              <?php } ?>
              <?php if (isset($error_number)) { ?>
              <div class="text-danger"><?php echo $error_number; ?></div>
              <?php } ?>
              <?php if (isset($error_min_size)) { ?>
              <div class="text-danger"><?php echo $error_min_size; ?></div>
              <?php } ?>
            </div>
          </div>
          
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-level"><?php echo $entry_level; ?></label>
            <div class="col-sm-10">
	           <select name="qrcode_level" id="input-level" class="form-control">
	            <?php if ('L' == $qrcode_level) { ?>
		            <option value="L" selected="selected"><?php echo $text_level_L; ?></option>
		            <option value="M"><?php echo $text_level_M; ?></option>
		            <option value="Q"><?php echo $text_level_Q; ?></option>
		            <option value="H"><?php echo $text_level_H; ?></option>
	            <?php } elseif('M' == $qrcode_level) { ?>
	            	<option value="L"><?php echo $text_level_L; ?></option>
		            <option value="M" selected="selected"><?php echo $text_level_M; ?></option>
		            <option value="Q"><?php echo $text_level_Q; ?></option>
		            <option value="H"><?php echo $text_level_H; ?></option>
	            <?php } elseif('Q' == $qrcode_level) { ?>
	            	<option value="L"><?php echo $text_level_L; ?></option>
		            <option value="M"><?php echo $text_level_M; ?></option>
		            <option value="Q" selected="selected"><?php echo $text_level_Q; ?></option>
		            <option value="H"><?php echo $text_level_H; ?></option>
	            <?php }  else { ?>
	            	<option value="L"><?php echo $text_level_L; ?></option>
		            <option value="M"><?php echo $text_level_M; ?></option>
		            <option value="Q"><?php echo $text_level_Q; ?></option>
		            <option value="H" selected="selected"><?php echo $text_level_H; ?></option>
	            <?php } ?>
	          </select>
            </div>
          </div>
          
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-size"><?php echo $entry_margin; ?></label>
            <div class="col-sm-10">
              <input type="text" name="qrcode_margin" value="<?php echo $qrcode_margin; ?>" placeholder="<?php echo $entry_margin; ?>" id="input-margin" class="form-control" />
              <?php if (isset($error_margin)) { ?>
              <div class="text-danger"><?php echo $error_margin; ?></div>
              <?php } ?>
            </div>
          </div>
          
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-logo"><?php echo $entry_logo; ?></label>
            <div class="col-sm-10"><a href="" id="thumb-image" data-toggle="image" class="img-thumbnail"><img src="<?php echo $thumb; ?>" alt="" title="" data-placeholder="<?php echo $placeholder; ?>" /></a>
              <input type="hidden" name="qrcode_logo" value="<?php echo $qrcode_logo; ?>" id="input-image" />
            </div>
          </div>
          
      	  <div class="form-group">
	        <label class="col-sm-2 control-label" for="input-status"><?php echo $entry_status; ?></label>
	        <div class="col-sm-10">
	          <select name="qrcode_status" id="input-status" class="form-control">
	            <?php if ($qrcode_status) { ?>
	            <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
	            <option value="0"><?php echo $text_disabled; ?></option>
	            <?php } else { ?>
	            <option value="1"><?php echo $text_enabled; ?></option>
	            <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
	            <?php } ?>
	          </select>
	        </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<?php echo $footer; ?>