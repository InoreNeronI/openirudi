<?php
//if (!in_array($sf_request->getParameter('module'), array('my_login', 'list_to_work'))):

    $des = array('', '', '', '', '', '', '');
    if ($sf_request->getParameter('module') == 'menu') {
        $des[0] = 'active';
    } elseif ($sf_request->getParameter('module') == 'image' && $sf_request->getParameter('action') == 'newImage1') {
        $des[1] = 'active';
    } elseif ($sf_request->getParameter('module') == 'image') {
        $des[2] = 'active';
    } elseif ($sf_request->getParameter('module') == 'partition') {
        $des[3] = 'active';
    } elseif ($sf_request->getParameter('module') == 'config') {
        $des[4] = 'active';
    } elseif ($sf_request->getParameter('module') == 'computer') {
        $des[5] = 'active';
    } elseif ($sf_request->getParameter('module') == 'list_to_work' || $sf_request->getParameter('module') == 'my_login' ) {
        unset($des);
    }
?>
<?php if (isset($des) && $sf_user->isAuthenticated()): ?>
        <ul class="menu">
<?php
        echo '<li class="' . $des[0] . '"> ' . link_to(__('principal'), 'menu/index') . '</li>';
        echo '<li class="' . $des[1] . '"> ' . link_to(__('crear imagen'), 'image/newImage1') . '</li>';
        echo '<li class="' . $des[2] . '"> ' . link_to(__('restaurar image'), 'image/index') . '</li>';
        echo '<li class="' . $des[3] . '"> ' . link_to(__('gestionar disco'), 'partition/index') . '</li>';
        echo '<li class="' . $des[4] . '"> ' . link_to(__('configuracion'), 'config/index') . '</li>';
        echo '<li class="' . $des[5] . '"> ' . link_to(__('hardware'), 'computer/reload') . '</li>';
        echo '<li class="' . $des[6] . '"> ' . link_to(__('Logout'), 'list_to_work/index') . '</li>';
?>

    </ul>
    <?php endif; ?>
    <?php //endif; ?>