<?php

namespace App\Controller;

use Stripe\Stripe;
use App\Repository\OrderRepository;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Stripe\Checkout\Session;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @package App\Controller
 */
class StripeController extends AbstractController
{
    /**
     * Doctrine
     *
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * Order repository
     *
     * @var OrderRepository
     */
    private $orderRepository;

    private $productRepository;

    /**
     * Constructeur
     *
     * @param EntityManagerInterface $entityManager
     * @param OrderRepository $orderRepository
     * @param ProductRepository $productRepository
     */
    public function __construct(EntityManagerInterface $entityManager,
        OrderRepository $orderRepository, 
        ProductRepository $productRepository)
    {
        $this->entityManager = $entityManager;
        $this->orderRepository = $orderRepository;
        $this->productRepository = $productRepository;
    }

    /**
     * @Route("/order/create-stripe-session/{reference}", name="stripe_create_session")
     *
     * @param String $reference
     * @return Response
     */
    public function index($reference): Response
    {
        $order = $this->orderRepository->findOneBy(['reference' => $reference]);
        if (!$order) {
            return $this->redirectToRoute('order');
        }

        $productStripe = [];
        $YOUR_DOMAIN = 'https://127.0.0.1:8000';

        foreach ($order->getDetails()->getValues() as $product) {
            $productCart = $this->productRepository->findOneBy(['name' => $product->getProduct()]);

            $productStripe[] = [
                'price_data' => [
                    'currency' => 'EUR',
                    'unit_amount' => $product->getPrice(),
                    'product_data' => [
                        'name' => $product->getProduct(),
                        'images' => [$YOUR_DOMAIN."/uploads/".$productCart->getImage()],
                    ],
                ],
                'quantity' => $product->getQuantity(),
            ];
        }

        $productStripe[] = [
            'price_data' => [
                'currency' => 'EUR',
                'unit_amount' => $order->getCarrierPrice(),
                'product_data' => [
                    'name' => $order->getCarrierName(),
                    'images' => [$YOUR_DOMAIN],
                ],
            ],
            'quantity' => 1,
        ];

        Stripe::setApiKey('sk_test_51Kfp8lLK2LOQr3VsFqVGKa6rL4bVHfpJDA7TZbNDqIMneZNDJ1c5USOyvkDTL5otDm34hAB0M8Xnk3shNQJVZv0L00LVFT58x8');

        $checkout_session = Session::create([
            'customer_email' => $this->getUser()->getEmail(),
            'payment_method_types' => ['card'],
            'line_items' => [[
                $productStripe
            ]],
            'mode' => 'payment',
            'success_url' => $YOUR_DOMAIN . '/order/success/{CHECKOUT_SESSION_ID}',
            'cancel_url' => $YOUR_DOMAIN . '/order/error/{CHECKOUT_SESSION_ID}',
        ]);
        
        $order->setStripe($checkout_session->id);
        $this->entityManager->flush();

        return $this->redirect($checkout_session->url);
    }
}
