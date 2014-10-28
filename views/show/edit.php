<form class='studip_form' method='post' action='<?= $controller->url_for('show/edit/'.$log->id) ?>'>
    <label>
        <?= _('Bezeichnung') ?>
        <input placeholder="Studip Log" type='text' name='logreader[name]' value='<?= $log->name ?>'>
    </label>

    <label>
        <?= _('Ort') ?>
        <input placeholder="/var/logs/index.log" type='text' name='logreader[location]' value='<?= $log->location ?>'>
    </label>
    
    <?= \Studip\Button::create(_('Speichern'), 'store') ?>

</form>
