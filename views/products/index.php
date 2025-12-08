<h1>Certificates</h1>
<div class="products">
    <?php foreach ($certificates as $certificate): ?>
        <div class="product">
            <img src="<?= $certificate->image ?>" alt="<?= $certificate->title ?>" />
            <h2><?= $certificate->title ?></h2>
            <p><?= $certificate->description ?></p>
            <p>Price: $<?= number_format($certificate->price, 2) ?></p>
            <form method="POST" action="/cart/add">
                <input type="hidden" name="certificate_id" value="<?= $certificate->id ?>">
                <label>Custom Name: <input type="text" name="custom_name"></label>
                <button type="submit">Add to Cart</button>
            </form>
        </div>
    <?php endforeach; ?>
</div>
