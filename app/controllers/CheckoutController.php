<?php
    namespace App\controllers;

    use App\services\ShopifyService;
    use App\repositories\UserRepository;
    use App\repositories\TransactionRepository;

    class CheckoutController
    {
        private ShopifyService $shopify;
        private UserRepository $users;
        private TransactionRepository $transactions;

        public function __construct()
        {
            $this->shopify      = new ShopifyService();
            $this->users        = new UserRepository();
            $this->transactions = new TransactionRepository();
        }

        /**
         * Start checkout for a membership plan
         */
        public function startCheckout()
        {
            $planId = $_POST['plan_id'] ?? null;
            if (!$planId) {
                echo "No plan selected.";
                return;
            }

            // Example line item
            $lineItems = [
                [
                    'variant_id' => $planId,
                    'quantity'   => 1
                ]
            ];

            $checkoutUrl = $this->shopify->createCheckout($lineItems);
            header("Location: {$checkoutUrl}");
        }

        /**
         * Handle Shopify webhook
         */
        public function webhook()
        {
            $data = file_get_contents('php://input');

        // Allow CLI testing
        if (PHP_SAPI === 'cli' && isset($GLOBALS['TEST_WEBHOOK_DATA'])) {
            $data = $GLOBALS['TEST_WEBHOOK_DATA'];
        }

        $hmacHeader = $_SERVER['HTTP_X_SHOPIFY_HMAC_SHA256'] ?? '';

        if (!$this->shopify->verifyWebhook($data, $hmacHeader)) {
            echo "Invalid signature";
            return;
        }

            $payload = json_decode($data, true);

            $userId = $payload['customer']['id'] ?? null;
            $planId = $payload['line_items'][0]['variant_id'] ?? null;
            $amount = $payload['total_price'] ?? 0;

            if ($userId && $planId) {
                // Update user membership
                $this->users->updateMembership($userId, $planId);

                // Store transaction
                $this->transactions->create([
                    'user_id' => $userId,
                    'shopify_order_id' => $payload['id'],
                    'status' => $payload['financial_status'],
                    'amount' => $amount,
                ]);
            }

            http_response_code(200);
            echo "Webhook processed";
        }
    }
