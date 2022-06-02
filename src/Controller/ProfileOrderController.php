<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProfileOrderController extends AbstractController
{
    /**
     * @Route("/profile/order", name="profile_order")
     */
    public function index(): Response
    {
        return $this->render('profile/order.html.twig');
    }
}
