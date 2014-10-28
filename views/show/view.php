<h3><?= htmlReady($log->name) ?></h3>
<? foreach ($log->file as $row): ?>
    <p class="entry"><?= htmlReady($row) ?><p>
    <? endforeach; ?>