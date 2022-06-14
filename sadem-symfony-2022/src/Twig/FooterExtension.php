<?php

namespace App\Twig;

use App\Repository\NetworkRepository;
use Twig\Environment;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;


class FooterExtension extends AbstractExtension
{

    private $networkRepository;
    private $twig;

    public function __construct(NetworkRepository $networkRepository, Environment $twig)
    {
        $this->networkRepository = $networkRepository;
        $this->twig = $twig;
    }


    public function getFunctions(): array
    {
        return [
            new TwigFunction('footer', [$this, 'doSomething'], ['is_safe' => ['html']]),
        ];
    }

    public function doSomething()
    {
        $networks = $this->networkRepository->findAll();
        return $this->twig->render('Front/partials/_footer.html.twig', [
            'networks' => $networks
        ]);
    }
}
