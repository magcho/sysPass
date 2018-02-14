<?php
/** @var $icons \Theme\Icons */
?>
<div class="item-actions">
    <ul>
        <?php /** @var \SP\Html\DataGrid\DataGridActionInterface[] $actions */
        foreach ($actions as $action): ?>
            <li>
                <button id="<?php echo $action->getId(); ?>"
                        class="<?php echo $action->getClassesAsString(); ?> mdl-button mdl-js-button mdl-button--fab mdl-button--mini-fab mdl-button--colored <?php echo $action->getIcon()->getClassButton(); ?>"
                    <?php foreach ($action->getData() as $key => $value): echo 'data-', $key, '="', $value, '"'; endforeach; ?>
                    <?php foreach ($action->getAttributes() as $key => $value): echo $key, '="', $value, '"'; endforeach; ?>
                        title="<?php echo $action->getTitle(); ?>">
                    <i class="material-icons"><?php echo $action->getIcon()->getIcon(); ?></i>
                </button>
            </li>
        <?php endforeach; ?>
    </ul>
</div>