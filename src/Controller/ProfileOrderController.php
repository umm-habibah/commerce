<?php

namespace App\Controller;

use App\Repository\OrderRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProfileOrderController extends AbstractController
{
    private $repository;

    public function __construct(OrderRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @Route("/profile/order", name="profile_order")
     */
    public function index(): Response
    {
        return $this->render('profile/order.html.twig');
    }

    /**
     * @Route("/profile/order/{reference}", name="profile_order_show")
     *
     * @param string $reference
     * @return Response
     */
    public function show($reference): Response
    {
        $order = $this->repository->findOneBy(['reference' => $reference]);
        if (!$order) {
            return $this->redirectToRoute('profile_order');
        }
        return $this->render('profile/order_show.html.twig', [
            'order' => $order
        ]); 
    }
}
