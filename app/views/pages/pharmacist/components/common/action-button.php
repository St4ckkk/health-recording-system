<!-- components/common/action-button.php -->
<button 
    type="button" 
    class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-md shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors"
    <?php if(isset($data_modal)): ?>data-modal="<?= $data_modal ?>"<?php endif; ?>
    <?php if(isset($data_action)): ?>data-action="<?= $data_action ?>"<?php endif; ?>
>
    <?php if(isset($icon)): ?>
        <i class="bx <?= $icon ?> mr-2"></i>
    <?php endif; ?>
    <?= $text ?>
</button>