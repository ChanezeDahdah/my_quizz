<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

    /**
     * Class QuestionnaireController
     * @package App/Controller
     */

class QuizzController extends AbstractController
{

/**
 * @Route("/quizz/{categorie}", name="test")
 * @return Response
 */

    public function test($categorie): Response
    {

        $categorie = $this->getDoctrine()
            ->getRepository(Categorie::class)
            ->find($categorie_id);


        if ($categorie == null) {
            return $this->render("error/404.html.twig");
        }
        $questions = $this->getDoctrine()
            ->getRepository(Question::class)
            ->findBy(["idCategorie" => "$categorie_id"]);


        return $this->render("quizz/index.html.twig", [
            "categorie" => $categorie,
        ]);
    }
    /**
     * @Route("/quizz/fin/resultat", name="resultat", methods={"POST","GET"})
     */

    public function resultat(): Response
    {
        if (count($_POST) == 0) {
            return $this->render("error/404.html.twig");
        }

        $question = count($_POST) - 1;
        $bonnereponse = 0;

    //     $categorie = new Categorie();
    //     $form = $this->createForm(CategorieType::class, $categorie);
    //     $form->handleRequest($request);

    //     if ($form->isSubmitted() && $form->isValid()) {
    //         $entityManager = $this->getDoctrine()->getManager();
    //         $entityManager->persist($categorie);
    //         $entityManager->flush();

        if ($bonnereponse >= $question / 2) {
            $congratulations = "Bien ouej ! tu as eu au dessus de la moyenne gourgandine !";
        }
        if ($bonnereponse <= $question / 2) {
            $congratulations = "Pas Ouf ! tu n'as meme pas la moyenne gredin !";
        }
        if ($bonnereponse == $question / 2) {
            $congratulations = "Tu as la moyenne ! Techniquement avec la moyenne tu as le bac  !";
        }
        if ($bonnereponse == 0) {
            $congratulations = "Nul ! 0 pointé pour la godiche !";
        }
        if ($bonnereponse == $question) {
            $congratulations = "Felicitations ! Tu n'es pas un fripon ! ";
        }

        $_SESSION[$_POST['name']] = "$bonnereponse/$question";


        return $this->render("quizz/result.html.twig", [
            "question" => $question,
            "bonnereponse" => "$bonnereponse",
            "congratulations" => "$congratulations",
            "titre" => $_POST['name']
        ]);
    }
    /**
     * @Route("/historique", name="historique")
     */
    public function historique(): Response
    {
        // if (!isset($_SESSION)) {

        //     return $this->render('index/historique_vide.html.twig');
        // } else
        return $this->render('index/historique.html.twig', [
            "historiques" => $_SESSION
        ]);
    }
}
