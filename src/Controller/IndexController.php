<?php

namespace App\Controller;

use App\Entity\Article;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use App\Form\ArticleType;

class IndexController extends AbstractController
{
    /**
     * @Route("/", name="article_list", methods={"GET"})
     */
    public function home(ManagerRegistry $doctrine): Response
    {
        // Récupérer tous les articles de la table "article" de la base de données
        $articles = $doctrine->getRepository(Article::class)->findAll();

        // Transmettre les articles à la vue 'index.html.twig'
        return $this->render('index.html.twig', ['articles' => $articles]);
    }

    /**
     * @Route("/article/save", name="save_article", methods={"GET"})
     */
    public function save(ManagerRegistry $doctrine): Response
    {
        $entityManager = $doctrine->getManager();

        $article = new Article();
        $article->setNom('Article 1');
        $article->setPrix(1000);

        $entityManager->persist($article);
        $entityManager->flush();

        return new Response('Article enregistré avec id ' . $article->getId());
    }
 /**
     * @Route("/article/{id}", name="article_show", methods={"GET"})
     */
    public function show($id, ManagerRegistry $doctrine): Response
    {
        // Utiliser le ManagerRegistry pour obtenir le repository de l'article
        $article = $doctrine->getRepository(Article::class)->find($id);

        // Vérifiez si l'article existe
        if (!$article) {
            throw $this->createNotFoundException('Article non trouvé');
        }

        // Renvoyer la vue avec l'article
        return $this->render('articles/show.html.twig', [
            'article' => $article,
        ]);
    }
  /**
 * @Route("/article/new", name="new_article", methods={"GET", "POST"})
 */
public function new(Request $request, ManagerRegistry $doctrine): Response
{
    // Créer une nouvelle instance d'Article
    $article = new Article();

    // Créer le formulaire associé à l'entité Article
    $form = $this->createForm(ArticleType::class, $article);

    // Gérer la requête du formulaire
    $form->handleRequest($request);

    // Si le formulaire est soumis et valide
    if ($form->isSubmitted() && $form->isValid()) {
        // Récupérer les données soumises par le formulaire
        $article = $form->getData();

        // Sauvegarder les données dans la base de données
        $entityManager = $doctrine->getManager();
        $entityManager->persist($article);
        $entityManager->flush();

        // Rediriger vers la liste des articles
        return $this->redirectToRoute('article_list');
    }

    // Rendre le template du formulaire
    return $this->render('articles/new.html.twig', [
        'form' => $form->createView(),
    ]);
}

     /**
     * @Route("/article/edit/{id}", name="edit_article", methods={"GET", "POST"})
     */
    public function edit(Request $request, $id, ManagerRegistry $doctrine): Response
    {
        // Utilisation de l'injection de dépendances pour accéder au repository
        $article = $doctrine->getRepository(Article::class)->find($id);

        // Vérifiez si l'article a été trouvé
        if (!$article) {
            throw $this->createNotFoundException("L'article avec l'ID $id n'existe pas.");
        }

        // Créer le formulaire en liant l'entité Article
        $form = $this->createForm(ArticleType::class, $article);

        // Gérer la requête
        $form->handleRequest($request);

        // Si le formulaire est soumis et valide
        if ($form->isSubmitted() && $form->isValid()) {
            // Sauvegarder les modifications dans la base de données
            $entityManager = $doctrine->getManager();
            $entityManager->persist($article);
            $entityManager->flush();

            // Rediriger vers une autre page après la soumission
            return $this->redirectToRoute('article_list');
        }

        // Rendre la vue du formulaire
        return $this->render('articles/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }

 /**
 * @Route("/article/delete/{id}", name="delete_article", methods={"DELETE"})
 */
public function delete(Request $request, $id, ManagerRegistry $doctrine): Response {
    // Récupérer l'article
    $article = $doctrine->getRepository(Article::class)->find($id);

    // Vérifiez si l'article existe
    if (!$article) {
        throw $this->createNotFoundException('Article non trouvé');
    }

    // Supprimer l'article
    $entityManager = $doctrine->getManager();
    $entityManager->remove($article);
    $entityManager->flush();

    // Rediriger vers la liste des articles
    return $this->redirectToRoute('article_list');
}
}
