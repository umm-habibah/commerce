<?php

namespace App\Controller;

use App\Classes\Cart;
use App\Entity\Detail;
use App\Entity\Order;
use App\Form\OrderType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @package App\Controller
 */
class OrderController extends AbstractController
{
    /**
     * Doctrine
     *
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * Constructeur
     *
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/order", name="order")
     *
     * @param Cart $cart
     * @return Response
     */
    public function index(Cart $cart): Response
    {
        if (!$this->getUser()->getAddresses()->getValues()) {
            return $this->redirectToRoute('profile_address_add');
        }

        $form = $this->createForm(OrderType::class, null, ['user' => $this->getUser()]);

        return $this->renderForm('order/index.html.twig', [
            'form' => $form,
            'cart' => $cart->getAll()
        ]);
    }

    /**
     * @Route("/order/checkout", name="order_checkout", methods={"POST"})
     *
     * @param Cart $cart
     * @param Request $request
     * @return Response
     */
    public function add(Cart $cart, Request $request): Response
    {
        $form = $this->createForm(OrderType::class, null, ['user' => $this->getUser()]);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $address = $form->get('addresses')->getData();
            $carrier = $form->get('carriers')->getData();

            $shipping_address = $address->getLastname().' '.$address->getFirstname();
            $shipping_address .= '<br>'.$address->getAddress().', '.$address->getCountry();
            $shipping_address .= '<br>'.$address->getZipcode().' - '.$address->getCity();
            $shipping_address .= '<br>'.$address->getPhone();

            $order = new Order();
            $date = new \DateTime();

            $reference = $date->format('dmY').'-'.uniqid();
            $order->setReference($reference);
            $order->setUser($this->getUser());
            $order->setCreatedAt($date);
            $order->setCarrierName($carrier->getName());
            $order->setCarrierPrice($carrier->getPrice());
            $order->setAddress($shipping_address);
            $order->setState(1);

            $this->entityManager->persist($order);


            foreach ($cart->getAll() as $product) {
                $detail = new Detail();
                $detail->setTheOrder($order);
                $detail->setProduct($product['product']->getName());
                $detail->setPrice($product['product']->getPrice());
                $detail->setQuantity($product['quantity']);
                $detail->setTotal($product['product']->getPrice() * $product['quantity']);

                $this->entityManager->persist($detail);
            }

            $this->entityManager->flush();

            return $this->render('order/add.html.twig', [
                'cart' => $cart->getAll(),
                'carrier' => $carrier,
                'address' => $shipping_address,
                'reference' => $order->getReference()
            ]);
        }

        return $this->redirectToRoute('cart');
    }
}
