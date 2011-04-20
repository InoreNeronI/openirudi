<td>
  <ul class="sf_admin_td_actions">
    <?php //echo $helper->linkToEdit($driver, array(  'params' =>   array(  ),  'class_suffix' => 'edit',  'label' => 'Edit',)) ?>
    <?php //echo $helper->linkToDelete($driver, array(  'params' =>   array(  ),  'confirm' => 'Are you sure?',  'class_suffix' => 'delete',  'label' => 'Delete',)) ?>
    <?php echo $helper->linkToView($driver, array(  'params' =>   array(  ),  'class_suffix' => 'view',  'label' => 'View',)) ?>
    <?php echo $helper->linkToFile($driver, array(  'params' =>   array(  ),  'class_suffix' => 'file',  'label' => 'File', 'file' => $driver->getUrl(),)) ?>
    <?php echo $helper->linkToFolder($driver, array(  'params' =>   array(  ),  'class_suffix' => 'folder',  'label' => 'Folder', 'folder' => pathinfo($driver->getUrl(), PATHINFO_DIRNAME),)) ?>
    <?php echo $helper->linkToZip($driver->getId(), array(  'params' =>   array(  ),  'class_suffix' => 'zip',  'label' => 'Zip',)) ?>
  </ul>
</td>
