<?php

namespace App\Controller;

use App\Classes\Search;
use App\Entity\Product;
use App\Form\SearchType;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{
    /**
     * Doctrine.
     *
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * Constructeur.
     *
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/product", name="products")
     *
     * @return Response
     */
    public function index(Request $request, ProductRepository $repository): Response
    {
        $search = new Search();
        $form = $this->createForm(SearchType::class, $search);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $products = $repository->findBySearch($search);
        } else {
            $products = $repository->findAll();
        }
        return $this->renderForm('product/index.html.twig', [
            'products' => $products,
            'form' => $form
        ]);
    }

    /**
     * @Route("/product/{slug}", name="product")
     *
     * @param string $slug
     * @return Response
     */
    public function show($slug): Response
    {
        $product = $this->entityManager->getRepository(Product::class)->findOneBy(['slug' => $slug]);
        if (!$product) {
            return $this->redirectToRoute('products');
        }
        return $this->render('product/show.html.twig', [
            'product' => $product
        ]);
    }
}
