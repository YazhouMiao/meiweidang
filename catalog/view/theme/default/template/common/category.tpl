<?php echo $header; ?>
<div class="vertical-margin-10 hidden-xs"></div>
<div class="container">
  <div class="row"><?php echo $column_left; ?>
    <?php if ($column_left && $column_right) { ?>
    <?php $class = 'col-sm-6'; ?>
    <?php } elseif ($column_left || $column_right) { ?>
    <?php $class = 'col-sm-9'; ?>
    <?php } else { ?>
    <?php $class = 'col-sm-12'; ?>
    <?php } ?>
    <div id="content" class="<?php echo $class; ?>">
        <?php echo $content_top; ?>
        <div class="category">
        <?php if ($categories) { ?>
          <?php foreach ($categories as $category) { ?>
          <div class="col-xs-12 inner-bg category-parent">
              <div class="pull-left"><?php echo $category['name']; ?></div> 
              <div class="pull-right"><a href="<?php echo $category['href']; ?>"><i class="fa fa-hand-o-right"></i></a></div>
          </div>
          <?php if ($category['children']) { ?>
              <?php foreach ($category['children'] as $children) { ?>
              <div class="col-xs-6">
                <div class="text-center category-child">
                  <a href="<?php echo $children['href']; ?>"><?php echo $children['name']; ?></a>
                </div>
              </div>
              <?php } ?>
          <?php } ?>
          <?php } ?>
        <?php } ?>
        </div>
        <?php echo $content_bottom; ?>
    </div>
    <?php echo $column_right; ?>
  </div>
</div>
<?php echo $footer; ?>
