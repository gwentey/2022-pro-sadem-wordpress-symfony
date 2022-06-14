<?php

namespace App\Controller\Admin;

use App\Form\NetworkType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\NetworkRepository;
use Symfony\Component\HttpFoundation\Request;


class ReglagesController extends AbstractController
{
    #[Route('/reglages/edit', name: 'reglagesEdit')]
    public function new(Request $request, NetworkRepository $networkRepository): Response
    {

        $networks = $networkRepository->findAll();


        $form = $this->createForm(NetworkType::class);


        return $this->render('admin/reglages/index.html.twig', [
            "form" => $form->createView(),
            'networks' => $networks
        ]);
    }

    #[Route('/reglages', name: 'reglages')]
    public function index(NetworkRepository $networkRepository): Response
    {
        $networks = $networkRepository->findAll();

        return $this->render('Admin/reglages.html.twig', [
            'controller_name' => 'ReglagesController',
            'networks' => $networks
        ]);
    }
}
