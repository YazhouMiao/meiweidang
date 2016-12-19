<div class="row">
  <div class="col-xs-12 select-item-bar">
  <?php foreach ($filter_groups as $filter_group) { ?>
    <div id="filter-group-<?php echo $filter_group['filter_group_id']; ?>" class="select-inner slide-menu">
      <ul class="filters">
          <li class="select-title"><?php echo $filter_group['name']; ?>：</li>
          <li><a href="<?php echo $filter_group['filter'][0]['href'];  unset($filter_group['filter'][0]); ?>" class="select <?php echo $filter_group['selected'] ? '' : 'active'; ?>"><?php echo $text_all; ?></a></li>
          <?php foreach ($filter_group['filter'] as $filter) { ?>
          <?php if (in_array($filter['filter_id'], $filter_category)) { ?>
            <li><a href="<?php echo $filter['href'] ?>" class="select active"><?php echo $filter['name']; ?></a></li>
          <?php } else { ?>
            <li><a href="<?php echo $filter['href'] ?>" class="select"><?php echo $filter['name']; ?></a></li>
          <?php } ?>
          <?php } ?>
      </ul>
    </div>
  <?php } ?>
  </div>
</div>