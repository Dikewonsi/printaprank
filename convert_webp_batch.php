<?php
// Batch convert all WebP images in /public/images/ to PNG

$imagesDir = __DIR__ . '/public/images/';
$files = glob($imagesDir . '*.webp');

if (!function_exists('imagecreatefromwebp')) {
    die("GD library does not support WebP on this server.\n");
}

foreach ($files as $webpPath) {
    $pngPath = preg_replace('/\.webp$/i', '.png', $webpPath);

    // Skip if PNG already exists
    if (file_exists($pngPath)) {
        echo "Already converted: " . basename($pngPath) . "\n";
        continue;
    }

    echo "Converting: " . basename($webpPath) . " → " . basename($pngPath) . "\n";

    $image = imagecreatefromwebp($webpPath);
    if (!$image) {
        echo "❌ Failed to load " . basename($webpPath) . "\n";
        continue;
    }

    imagepng($image, $pngPath);
    imagedestroy($image);

    echo "✅ Saved: " . basename($pngPath) . "\n";
}

echo "Batch conversion complete.\n";
