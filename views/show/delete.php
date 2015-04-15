<form class='studip_form' method='post' action='<?= $controller->url_for('show/delete/' . $log->id) ?>'>
    <p><?= sprintf(_('Log %s wirklich löschen?'), htmlReady($log->name)) ?></p>
    <?= \Studip\Button::create(_('Löschen'), 'confirm', array('data-dialog-button' => true)) ?>
</form>
