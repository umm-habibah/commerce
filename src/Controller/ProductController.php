<?php

namespace App\Controller;

use App\Classes\Search;
use App\Form\SearchType;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @package App\Controller
 */
class ProductController extends AbstractController
{
    /**
     * Product repository
     *
     * @var ProductRepository
     */
    private $repository;

    /**
     * Constructeur
     *
     * @param ProductRepository $repository
     */
    public function __construct(ProductRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @Route("/product", name="products")
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request): Response
    {
        $search = new Search();
        $form = $this->createForm(SearchType::class, $search);

        $form->handleRequest($request);

        $search->page = $request->get('page', 1);
        $products = $this->repository->findBySearch($search);

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
        $product = $this->repository->findOneBy(['slug' => $slug]);
        if (!$product) {
            return $this->redirectToRoute('products');
        }
        
        return $this->render('product/show.html.twig', [
            'product' => $product
        ]);
    }
}
