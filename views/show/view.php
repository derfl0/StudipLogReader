<h3><?= htmlReady($log->name) ?></h3>
<? foreach (array_slice($log->file, 0, 1000) as $row): ?>
    <p class="entry"><?= htmlReady($row) ?></p>
<? endforeach; ?>