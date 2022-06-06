<?php

namespace App\Classes;

use App\Repository\ProductRepository;
use Symfony\Component\HttpFoundation\RequestStack;

/**
 * @package App\Classes
 * Représentation d'un panier sous forme d'un tableau associatif (produit => quantité)
 * Opéation sur le panier
 */
class Cart
{
    /**
     * Session
     *
     * @var RequestStack
     */
    private $requestStack;

   /**
    * Product repository
    *
    * @var ProductRepository
    */
    private $repository;

    /**
     * Constructeur
     *
     * @param RequestStack $requestStack
     * @param ProductRepository $repository
     */
    public function __construct(RequestStack $requestStack, ProductRepository $repository)
    {
        $this->requestStack = $requestStack;
        $this->repository = $repository;
    }

    public function get()
    {
        $session = $this->requestStack->getSession();
        $cart = $session->get('cart');

        return $cart;
    }

    public function add($id)
    {
        $session = $this->requestStack->getSession();
        $cart = $session->get('cart');

        if (!empty($cart[$id])) {
            $cart[$id]++;
        } else {
            $cart[$id] = 1;
        }

        $session->set('cart', $cart);
    }

    public function delete($id)
    {
        $session = $this->requestStack->getSession();
        $cart = $session->get('cart');

        unset($cart[$id]);

        return $session->set('cart', $cart);
    }

    public function decrease($id)
    {
        $session = $this->requestStack->getSession();
        $cart = $session->get('cart');

        if ($cart[$id] > 1) {
            $cart[$id]--;
        } else {
            unset($cart[$id]);
        }

        return $session->set('cart', $cart);
    }

    public function getAll()
    {
        $cartComplete = [];
        if ($this->get()) {
            foreach ($this->get() as $id => $quantity) {
                $product = $this->repository->findOneBy(['id' => $id]);
                if (!$product) {
                    $this->delete($id);
                    continue;
                }

                $cartComplete[] = [
                    'product' => $product,
                    'quantity' => $quantity
                ];
            }
        }

        return $cartComplete;
    }
}
