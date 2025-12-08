<?php
namespace App\services;

use App\core\Env;

class ShopifyService
{
    private string $apiKey;
    private string $apiSecret;
    private string $storeDomain;

    public function __construct()
    {
        $this->apiKey      = Env::get('SHOPIFY_API_KEY') ?? '';
        $this->apiSecret   = Env::get('SHOPIFY_API_SECRET') ?? '';
        $this->storeDomain = Env::get('SHOPIFY_STORE_DOMAIN') ?? '';
    }

    /**
     * Create a checkout session for a product or membership plan
     */
    public function createCheckout(array $lineItems): string
    {
        $url = "https://{$this->storeDomain}/admin/api/2025-01/checkouts.json";

        $payload = [
            'checkout' => [
                'line_items' => $lineItems
            ]
        ];

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            "Content-Type: application/json",
            "X-Shopify-Access-Token: {$this->apiSecret}"
        ]);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($ch);
        curl_close($ch);

        $data = json_decode($response, true);

        return $data['checkout']['web_url'] ?? '';
    }

    /**
     * Verify webhook signature
     */
    public function verifyWebhook(string $data, string $hmacHeader): bool
    {
        $calculatedHmac = base64_encode(hash_hmac('sha256', $data, $this->apiSecret, true));
        return hash_equals($hmacHeader, $calculatedHmac);
    }
}
