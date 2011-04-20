
  <th id="sf_admin_list_th_type">
         <?php if ('type' == $sort[0]): ?>
    <?php echo link_to(__('Type', array(), 'messages'), 'type', array(), array('query_string' => 'sort=type&sort_type='.($sort[1] == 'asc' ? 'desc' : 'asc'))) ?>
    <?php echo image_tag(sfConfig::get('sf_admin_module_web_dir').'/images/'.$sort[1].'.png', array('alt' => __($sort[1], array(), 'sf_admin'), 'title' => __($sort[1], array(), 'sf_admin'))) ?>
  <?php else: ?>
    <?php echo link_to(__('Type', array(), 'messages'), 'type', array(), array('query_string' => 'sort=type&sort_type=asc')) ?>
  <?php endif; ?>
          </th>
