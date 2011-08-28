<!-- slot messages -->

<?php if (exceptionHandlerClass::exists('error')): ?>
    <div id="error">
    
        <!-- Errores -->
           <label><strong><?php echo __('Please, check following errors:') ?></strong></label>
       <div class="scroll-error">
        <div id="error_msg">
         
            <ul>
                <li><?php echo exceptionHandlerClass::listMessages('error') ?></li>
            </ul>
        </div>
        </div>
        <!-- /Errores -->
        <?php elseif (exceptionHandlerClass::exists('message')): ?>
         <div id="error">
        <div class="scroll-error">
      
    <?php endif; ?>

    <?php if (exceptionHandlerClass::exists('message')): ?>
        <!-- Alertas -->
        <div id="warning_msg">
            <ul>
                <li><?php echo exceptionHandlerClass::listMessages('message') ?></li>
            </ul>
        </div>
        <!-- /Alertas -->
        </div>
    </div>
<?php  elseif (exceptionHandlerClass::exists('error')): ?>
</div>
<?php endif; ?>