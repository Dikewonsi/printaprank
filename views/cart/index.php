<h1>Your Cart</h1>
<?php if (empty($cart)): ?>
    <p>No items in cart.</p>
<?php else: ?>
    <ul>
        <?php foreach ($cart as $item): ?>
            <li>
                <?= htmlspecialchars($item['title'] ?? 'Unknown') ?> 
                - $<?= number_format($item['price'] ?? 0, 2) ?>
                <br>Custom Name: <?= htmlspecialchars($item['custom_name'] ?? '') ?>
            </li>
        <?php endforeach; ?>
    </ul>
    <form method="POST" action="/checkout">
        <button type="submit">Proceed to Checkout</button>
    </form>
<?php endif; ?>
