<?php if ($membership): ?>
    <p>Your current plan: <strong><?= $membership->name ?></strong></p>
    <p>Download limit: <?= $membership->download_limit ?></p>
<?php else: ?>
    <p>You don’t have a membership yet. You can buy products individually.</p>
    <a href="/products">Browse Products</a>
<?php endif; ?>