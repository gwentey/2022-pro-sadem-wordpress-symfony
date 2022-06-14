<?php

namespace App\Controller\Front;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Account;



class InscriptionController extends AbstractController
{
    #[Route('/inscription', name: 'inscription')]
    public function index(UserPasswordHasherInterface $passwordHasher, ManagerRegistry $doctrine): Response
    {

        $entityManager = $doctrine->getManager();


        $user = new Account();
        $plaintextPassword = "admin";
        $user->setUsername("admin");
        // hash the password (based on the security.yaml config for the $user class)
        $hashedPassword = $passwordHasher->hashPassword(
            $user,
            $plaintextPassword
        );
        $user->setPassword($hashedPassword);

        // tell Doctrine you want to (eventually) save the Product (no queries yet)
        $entityManager->persist($user);

        // actually executes the queries (i.e. the INSERT query)
        $entityManager->flush();

        return $this->render('Front/inscription.html.twig', [
            'controller_name' => 'InscriptionController',
        ]);
    }
}
