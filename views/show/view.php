<h3><?= htmlReady($log->name) ?></h3>
<? foreach (array_slice($log->file, $from, $to) as $row): ?>
    <p class="entry"><?= htmlReady($row) ?></p>
<? endforeach; ?>