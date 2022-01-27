<tr>
<td class="header">
<a href="<?php echo e($url); ?>" style="display: inline-block;">
<?php if(trim($slot) === 'Punchly.io'): ?>
<img src="<?php echo e(asset('front_end/images/logo.png')); ?>" class="logo" alt="Laravel Logo">
<?php else: ?>
<?php echo e($slot); ?>

<?php endif; ?>
</a>
</td>
</tr>
<?php /**PATH /var/www/punchly/backend/resources/views/vendor/mail/html/header.blade.php ENDPATH**/ ?>