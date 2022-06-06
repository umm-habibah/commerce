<?php

namespace App\Controller;

use App\Form\ProfilePasswordType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class ProfilePasswordController extends AbstractController
{
    /**
     * Doctrine
     *
     * @var EntityManagerInterface
     */
    private $entityManager;

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
     * @param UserPasswordHasherInterface $hasher
     */
    public function __construct(EntityManagerInterface $entityManager, UserPasswordHasherInterface $hasher)
    {
        $this->entityManager = $entityManager;
        $this->hasher = $hasher;
    }

    /**
     * @Route("/profile/password", name="profile_password")
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request): Response
    {
        $user = $this->getUser();

        $form = $this->createForm(ProfilePasswordType::class, $user);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $old_password = $form->get('old_password')->getData();

            if ($this->hasher->isPasswordValid($user, $old_password)) {
                $new_password = $form->get('new_password')->getData();

                $password = $this->hasher->hashPassword($user, $new_password);
                $user->setPassword($password);

                $this->entityManager->flush();

                $this->addFlash('success', 'Votre mot de passe a été mise à jour.');

                return $this->redirectToRoute('profile');
            } else {
                $this->addFlash('danger', 'Le mot de passe est incorrect.');
            }
        }

        return $this->renderForm('profile/password.html.twig', [
            'form' => $form
        ]);
    }
}
