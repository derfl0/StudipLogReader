<h1><?= _('Logs') ?></h1>
<? if ($logs): ?>
    <? foreach ($logs as $log): ?>
        <article>
            <? if ($log->file): ?>
                <a href="<?= $controller->url_for('show/view/' . $log->id) ?>">
                    <?= htmlReady($log->name) ?>
                </a>
            <? else: ?>
                <?= htmlReady($log->name) ?>
            <? endif; ?>

            <a rel="lightbox" href="<?= $controller->url_for('show/edit/' . $log->id) ?>">
                <?= Assets::img('icons/16/blue/edit.png') ?>
            </a>
            <a rel="lightbox" href="<?= $controller->url_for('show/delete</' . $log->id) ?>">
                <?= Assets::img('icons/16/blue/trash.png') ?>
            </a>
        </article>
    <? endforeach; ?>
<? else: ?>
    <p>
        <?= _('Keine Logs vorhanden') ?>
    </p>
<? endif; ?>