<?php

namespace App\Controller;

use App\Entity\Customer;
use App\Form\UserRoleType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

class AdminController extends AbstractController
{
    #[Route('/admin/users', name: 'admin_user_list')]
    #[IsGranted('ROLE_ADMIN')]
    public function userList(EntityManagerInterface $entityManager): Response
    {
        $users = $entityManager->getRepository(Customer::class)->findAll();

        return $this->render('admin/user_list.html.twig', [
            'users' => $users,
        ]);
    }

    #[Route('/admin/users/{id}/edit', name: 'admin_user_edit')]
    #[IsGranted('ROLE_ADMIN')]
    public function editUser(Request $request, Customer $user, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(UserRoleType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('admin_user_list');
        }

        return $this->render('admin/edit_user.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }
}