<form class='studip_form' method='post' action='<?= $controller->url_for('show/delete/' . $log->id) ?>'>
    <p><?= sprintf(_('Log %s wirklich l�schen?'), htmlReady($log->name)) ?></p>
    <?= \Studip\Button::create(_('L�schen'), 'confirm', array('data-dialog-button' => true)) ?>
</form>
