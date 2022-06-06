<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegisterType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class RegisterController extends AbstractController
{
    /**
     * Doctrine.
     *
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * User repository
     *
     * @var UserRepository
     */
    private $repository;

    /**
     * Password hasher
     *
     * @var UserPasswordHasherInterface
     */
    private $hasher;

    /**
     * Constructeur
     *
     * @param EntityManagerInterface $entityManager
     * @param UserRepository $repository
     * @param UserPasswordHasherInterface $hasher
     */
    public function __construct(EntityManagerInterface $entityManager, UserRepository $repository, UserPasswordHasherInterface $hasher)
    {
        $this->entityManager = $entityManager;
        $this->repository = $repository;
        $this->hasher = $hasher;
    }

    /**
     * @Route("/register", name="register")
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request): Response
    {
        $user = new User();

        $form = $this->createForm(RegisterType::class, $user);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $user = $form->getData();

            $email = $this->repository->findOneBy(['email' => $user->getEmail()]);
            if (!$email) {
                $password = $this->hasher->hashPassword($user, $user->getPassword());
                $user->setPassword($password);

                $this->entityManager->persist($user);
                $this->entityManager->flush();

                $this->addFlash('success', 'Inscription validée.');
            } else {
                $this->addFlash('danger', 'Adresse e-mail déjà utilisée.');
            }
        }

        return $this->renderForm('register/index.html.twig', [
            'form' => $form
        ]);
    }
}
