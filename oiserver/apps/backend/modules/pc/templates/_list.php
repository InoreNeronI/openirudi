<div class="sf_admin_list">
  <?php if (!$pager->getNbResults()): ?>
    <p><?php echo __('No result', array(), 'sf_admin') ?></p>
  <?php else: ?>
	 <?php //kam?>
	 <form action="<?php echo url_for('@my_task_program') ?>" method="post">	
	 <?php include_partial('pc/better_task_actions')?>
	 <?php //?>
    <table cellspacing="0">
      <thead>
        <tr>
          <th id="sf_admin_list_batch_actions"><!--<input type="checkbox" onclick="boxes = document.getElementsByTagName('input'); for(index in boxes) { box = boxes[index]; if (box.type == 'checkbox' && box.className == 'sf_admin_batch_checkbox') box.checked = this.checked } return true;" />--></th>
          <?php include_partial('pc/list_th_tabular', array('sort' => $sort)) ?>
          <th id="sf_admin_list_th_actions"><?php echo __('Actions', array(), 'sf_admin') ?></th>
        </tr>
      </thead>
      <tfoot>
        <tr>
          <th colspan="10">
            <?php if ($pager->haveToPaginate()): ?>
              <?php include_partial('pc/pagination', array('pager' => $pager)) ?>
            <?php endif; ?>

            <?php echo format_number_choice('[0] no result|[1] 1 result|(1,+Inf] %1% results', array('%1%' => $pager->getNbResults()), $pager->getNbResults(), 'sf_admin') ?>
            <?php if ($pager->haveToPaginate()): ?>
              <?php echo __('(page %%page%%/%%nb_pages%%)', array('%%page%%' => $pager->getPage(), '%%nb_pages%%' => $pager->getLastPage()), 'sf_admin') ?>
            <?php endif; ?>
          </th>
        </tr>
      </tfoot>
      <tbody>
        <?php foreach ($pager->getResults() as $i => $pc): $odd = fmod(++$i, 2) ? 'odd' : 'even' ?>
          <tr class="sf_admin_row <?php echo $odd ?>">
			<?php include_partial('pc/list_td_batch_actions', array('pc' => $pc, 'helper' => $helper)) ?>	
            <?php include_partial('pc/list_td_tabular', array('pc' => $pc)) ?>
            <?php include_partial('pc/list_td_actions', array('pc' => $pc, 'helper' => $helper)) ?>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
	 <?php //kam?>
	 <?php include_partial('pc/better_task_actions')?>
  	 </form>
     <?php //?>
  <?php endif; ?>
</div>
