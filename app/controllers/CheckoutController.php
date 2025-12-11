<?php
    namespace App\controllers;

    use App\services\ShopifyService;
    use App\repositories\UserRepository;
    use App\repositories\TransactionRepository;
    use App\repositories\CertificateOrderRepository;

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
            $cart = $_SESSION['cart'] ?? [];
            if (empty($cart)) {
                echo "Cart is empty.";
                return;
            }

            $lineItems = [];
            foreach ($cart as $item) {
                // Fetch certificate from DB to get Shopify variant_id
                $certificate = \App\models\Certificate::find($item['product_id']);
                if ($certificate && !empty($certificate['shopify_variant_id'])) {
                    $lineItems[] = [
                        'variant_id' => $certificate['shopify_variant_id'],
                        'quantity'   => 1,
                        'properties' => [
                        'Awardee Name' => $item['awardee_name']
            ]
                    ];
                }
            }

            if (empty($lineItems)) {
                echo "No valid items in cart.";
                return;
            }

            $checkoutUrl = $this->shopify->createCheckout($lineItems);
            header("Location: {$checkoutUrl}");
            exit;
        }

        /**
         * Handle Shopify webhook
         */
        public function webhook()
        {
            $data = file_get_contents('php://input');
            if (PHP_SAPI === 'cli' && isset($GLOBALS['TEST_WEBHOOK_DATA'])) {
                $data = $GLOBALS['TEST_WEBHOOK_DATA'];
            }

            $hmacHeader = $_SERVER['HTTP_X_SHOPIFY_HMAC_SHA256'] ?? '';
            if (!$this->shopify->verifyWebhook($data, $hmacHeader)) {
                echo "Invalid signature";
                return;
            }

            $payload = json_decode($data, true);

            $orderId = $payload['id'] ?? null;
            $status  = $payload['financial_status'] ?? 'pending';
            $amount  = $payload['total_price'] ?? 0;
            $customer = $payload['customer'] ?? [];

            // Save transaction
            $this->transactions->create([
                'user_id'         => $customer['id'] ?? null,
                'shopify_order_id'=> $orderId,
                'status'          => $status,
                'amount'          => $amount,
            ]);

            // Save certificate orders
            $certificateOrders = new \App\repositories\CertificateOrderRepository();

            foreach ($payload['line_items'] as $lineItem) {
                $variantId = $lineItem['variant_id'];
                $certificate = \App\models\Certificate::findByVariant($variantId);

                if ($certificate) {
                    // Awardee name can be passed as cart metadata or session
                    $awardeeName = $_SESSION['cart'][0]['awardee_name'] ?? 'Unknown';

                    $certificateOrders->create([
                        'order_id'      => $orderId,
                        'certificate_id'=> $certificate['id'],
                        'awardee_name'  => $awardeeName,
                        'status'        => $status,
                    ]);
                }
            }

            http_response_code(200);
            echo "Webhook processed";
        }


    }
