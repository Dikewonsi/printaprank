<?php
namespace App\controllers;

use App\repositories\UserRepository;
use App\repositories\TransactionRepository;
use App\repositories\CertificateOrderRepository;

class CheckoutController
{
    private UserRepository $users;
    private TransactionRepository $transactions;
    

    public function __construct()
    {
        // session_start();
        if (!isset($_SESSION['user_id'])) {
            header("Location: /login");
            exit;
        }

        $this->users        = new UserRepository();
        $this->transactions = new TransactionRepository();
    }

    /**
     * Helper: Convert WebP to PNG (with caching)
     */
    private function convertWebpToPng(string $webpPath): string
    {
        if (!file_exists($webpPath)) {
            throw new \Exception("WebP file not found: $webpPath");
        }

        $pngPath = preg_replace('/\.webp$/i', '.png', $webpPath);

        // Reuse cached PNG if already converted
        if (file_exists($pngPath)) {
            return $pngPath;
        }

        if (!function_exists('imagecreatefromwebp')) {
            throw new \Exception("GD library does not support WebP on this server.");
        }

        $image = imagecreatefromwebp($webpPath);
        if (!$image) {
            throw new \Exception("Failed to load WebP image: $webpPath");
        }

        imagepng($image, $pngPath);
        imagedestroy($image);

        return $pngPath;
    }


    /**
     * Show fake checkout page
     */
    public function showCheckout()
    {
        $planId = $_GET['plan_id'] ?? null;
        if ($planId) {
            $plan = \App\models\Membership::find((int)$planId);
            include __DIR__ . '/../../views/checkout/index.php';
            return;
        }

        $cart = $_SESSION['cart'] ?? [];
        $cartWithDetails = [];

        foreach ($cart as $item) {
            if (($item['type'] ?? '') === 'certificate') {
                $certificate = \App\models\Certificate::find((int)$item['product_id']);
                if ($certificate) {
                    $cartWithDetails[] = [
                        'type'         => 'certificate',
                        'title'        => $certificate->title,
                        'description'  => $certificate->description,
                        'image'        => $certificate->image,
                        'price'        => $certificate->price,
                        'awardee_name' => $item['awardee_name'] ?? '',
                    ];
                }
            } elseif (($item['type'] ?? '') === 'membership') {
                $membership = \App\models\Membership::find((int)$item['membership_id']);
                if ($membership) {
                    $cartWithDetails[] = [
                        'type'        => 'membership',
                        'title'       => $membership->name,
                        'description' => $membership->description,
                        'price'       => $membership->price,
                        'download_limit' => $membership->download_limit,
                        'priority_support' => $membership->priority_support,
                    ];
                }
            }
        }

        include __DIR__ . '/../../views/checkout/index.php';
    }

    /**
     * Process fake payment
     */
    public function process()
    {
        $planId = $_POST['plan_id'] ?? null;
        $status = 'paid';
        $orderId = rand(100000, 999999);

        $itemsSummary = [];
        $amount = 0;

        if ($planId) {
            // Membership checkout (direct plan purchase)
            $plan = \App\models\Membership::find((int)$planId);

            if ($plan) {
                $this->transactions->create([
                    'user_id' => $_SESSION['user_id'],
                    'shopify_order_id' => $orderId,
                    'status' => $status,
                    'amount' => $plan->price,
                ]);

                // Update user membership
                $this->users->updateMembership($_SESSION['user_id'], $planId);

                // ✅ Refresh session user data
                $userRepo = new \App\repositories\UserRepository();
                $updatedUser = $userRepo->findById($_SESSION['user_id']);
                $_SESSION['user'] = [
                    'id'            => $updatedUser->id,
                    'name'          => $updatedUser->name,
                    'membership_id' => $updatedUser->membership_id,
                ];

                $itemsSummary[] = [
                    'type'        => 'membership',
                    'title'       => $plan->name,
                    'price'       => $plan->price,
                    'description' => $plan->description ?? '',
                ];

                $amount += $plan->price;
            }

        } else {
            // Mixed cart checkout (certificates + memberships)
            $cart = $_SESSION['cart'] ?? [];

            foreach ($cart as $item) {
                if ($item['type'] === 'certificate') {
                    $certificate = \App\models\Certificate::find((int)$item['product_id']);
                    if ($certificate) {
                        $amount += $certificate->price;

                        $certificateOrders = new \App\repositories\CertificateOrderRepository();
                        $certificateOrders->create([
                            'order_id'       => $orderId,
                            'certificate_id' => $certificate->id,
                            'awardee_name'   => $item['awardee_name'] ?? '',
                            'status'         => $status,
                            'user_id'        => $_SESSION['user_id'],
                        ]);

                        // ✅ Generate personalized certificate PDF
                        $name = $item['awardee_name'] ?? '';
                        $templatePath = __DIR__ . '/../../public' . $certificate->image;
                        if (str_ends_with(strtolower($templatePath), '.webp')) {
                            $templatePath = $this->convertWebpToPng($templatePath);
                        }

                        $pdf = new \FPDF('L', 'pt', [1106, 843]); 
                        $pdf->AddPage();
                        $pdf->Image($templatePath, 0, 0, 1106, 843);

                        $pdf->SetFillColor(255, 255, 255);
                        $pdf->Rect(300, 360, 500, 88, 'F');

                        $pdf->SetFont('Arial', 'B', 48);
                        $pdf->SetTextColor(0, 0, 0);

                        $textWidth = $pdf->GetStringWidth($name);
                        $pageWidth = 1106;
                        $x = ($pageWidth - $textWidth) / 2;
                        $y = 410;

                        $pdf->Text($x, $y, $name);

                        $fileName = "certificate_{$orderId}_{$certificate->id}.pdf";
                        $filePath = __DIR__ . "/../../storage/certificates/" . $fileName;
                        $pdf->Output('F', $filePath);

                        $itemsSummary[] = [
                            'type'         => 'certificate',
                            'title'        => $certificate->title,
                            'price'        => $certificate->price,
                            'awardee_name' => $item['awardee_name'] ?? '',
                            'id'           => $certificate->id,
                            'file_name'    => $fileName,
                        ];
                    }
                } elseif ($item['type'] === 'membership') {
                    $membership = \App\models\Membership::find((int)$item['membership_id']);
                    if ($membership) {
                        $amount += $membership->price;

                        // ✅ Update user membership here too
                        $this->users->updateMembership($_SESSION['user_id'], $membership->id);

                        // ✅ Refresh session user data
                        $userRepo = new \App\repositories\UserRepository();
                        $updatedUser = $userRepo->findById($_SESSION['user_id']);
                        $_SESSION['user'] = [
                            'id'            => $updatedUser->id,
                            'name'          => $updatedUser->name,
                            'membership_id' => $updatedUser->membership_id,
                        ];

                        $itemsSummary[] = [
                            'type'        => 'membership',
                            'title'       => $membership->name,
                            'price'       => $membership->price,
                            'description' => $membership->description ?? '',
                        ];
                    }
                }
            }

            $this->transactions->create([
                'user_id' => $_SESSION['user_id'],
                'shopify_order_id' => $orderId,
                'status' => $status,
                'amount' => $amount,
            ]);

            // Clear cart after checkout
            $_SESSION['cart'] = [];
        }

        // ✅ Save all items together for success page
        $_SESSION['last_order'] = [
            'order_id' => $orderId,
            'items'    => $itemsSummary,
        ];

        header("Location: /checkout/success?order_id={$orderId}");
        exit;
    }


    /**
     * Show success page
     */
    public function success()
    {
        $orderId = $_GET['order_id'] ?? null;
        include __DIR__ . '/../../views/checkout/success.php';
    }
}
