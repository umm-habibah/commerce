<?php

namespace App\Controller;

use App\Entity\Address;
use App\Form\ProfileAddressType;
use App\Repository\AddressRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProfileAddressController extends AbstractController
{
    private $repository;

    private $entityManager;

    public function __construct(AddressRepository $repository, EntityManagerInterface $entityManager)
    {
        $this->repository = $repository;
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/profile/address", name="profile_address")
     */
    public function index(): Response
    {
        return $this->render('profile/address.html.twig');
    }

    /**
     * @Route("/profile/address/edit/{id}", name="profile_address_edit")
     *
     * @param integer $id
     * @param Request $request
     * @return Response
     */
    public function edit($id, Request $request): Response
    {
        $address = $this->repository->findOneBy(['id' => $id]);
        if (!$address || $this->getUser() != $address->getUser()) {
            return $this->redirectToRoute('profile');
        }

        $form = $this->createForm(ProfileAddressType::class, $address);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $address->setUser($this->getUser());

            $this->entityManager->flush();

            $this->addFlash('info', 'Vos modifications ont été prises en compte.');

            return $this->redirectToRoute('profile_address');
        }
        return $this->renderForm('profile/address_form.html.twig', [
            'form' => $form
        ]);
    }

    /**
     * @Route("/profile/address/delete/{id}", name="profile_address_delete")
     *
     * @param integer $id
     * @return Response
     */
    public function delete($id): Response
    {
        $address = $this->repository->findOneBy(['id' => $id]);
        if ($address && $this->getUser() == $address->getUser()) {
            $this->entityManager->remove($address);
            $this->entityManager->flush();

            $this->addFlash('info', 'Vos modifications ont été prises en compte.');
        }
        return $this->redirectToRoute('profile_address');
    }

    /**
     * @Route("/profile/address/add", name="profile_address_add")
     *
     * @param Request $request
     * @return Response
     */
    public function add(Request $request): Response
    {
        $address = new Address();

        $form = $this->createForm(ProfileAddressType::class, $address);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $address->setUser($this->getUser());
            $this->entityManager->persist($address);
            $this->entityManager->flush();

            $this->addFlash('success', 'Votre adresse a été enregistrée.');

            return $this->redirectToRoute('profile_address');
        }
        return $this->renderForm('profile/address_form.html.twig', [
            'form' => $form
        ]);
    }
}
