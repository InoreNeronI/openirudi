<td>
    <ul class="sf_admin_td_actions">
        <?php echo $helper->linkToEdit($oiimages, array(  'params' =>   array(  ),  'class_suffix' => 'edit',  'label' => 'Edit',)) ?>
        <?php echo $helper->linkToView($oiimages->getId()); ?>
        <?php if (!$oiimages->isOpenirudi()): ?>
        <?php echo $helper->linkToDelete($oiimages, array('params' => array(), 'confirm' => 'Are you sure?', 'class_suffix' => 'delete', 'label' => 'Delete',)) ?>
        <?php endif; ?>
    </ul>
</td>
