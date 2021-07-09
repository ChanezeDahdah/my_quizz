<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Categorie;


class IndexController extends AbstractController
{
    /**
     * @Route("/", name="index")
     */
    public function index(): Response
    {
        $categories = $this->getDoctrine()
            ->getRepository(Categorie::class)
            ->findAll();



        return $this->render('index/index.html.twig', [
            'controller_name' => 'IndexController',
            'categories' => $categories,
        ]);
    }

    /**
     * @Route("/historique", name="historique")
     */
    public function historique(): Response
    {
        if (!isset($_SESSION)) {

            return $this->render('index/historique_vide.html.twig');
        } else
            return $this->render('index/historique.html.twig', [
                "historiques" => $_SESSION
            ]);
    }
}
