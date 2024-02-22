<?php

namespace App\Controller;

use App\Entity\Article;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use App\Repository\ArticleRepository;
use Doctrine\ORM\EntityManagerInterface;

#[Route('/panier')]
class PanierController extends AbstractController
{
    #[Route('/', name: 'app_panier')]
    public function index(SessionInterface $session, ArticleRepository $articleRepository): Response
    {
        // Get the panier data from the session, ensuring it's an array
        $panier = (array) $session->get("panier", []);
    
        $dataPanier = [];
        $total = 0;
    
        // Check if $panier is indeed an array
        if (is_array($panier)) {
            foreach ($panier as $id => $quantite) {
                // Fetch the article corresponding to $id
                $article = $articleRepository->find($id);
    
                // Ensure $article is not null before proceeding
                if ($article) {
                    $dataPanier[] = [
                        "article" => $article,
                        "quantite" => $quantite,
                    ];
    
                    // Calculate total
                    $total += $article->getPrix() * $quantite;
                }
            }
        }
    
        return $this->render('panier/index.html.twig', compact("dataPanier", "total"));
    }

    #[Route('/add/{id}', name: 'add_panier')]
    public function add(Article $article, SessionInterface $session)
    {
        // Récupérer le panier depuis la session
        $panier = $session->get("panier", []);

        // Assurer que $panier est un tableau
        if (!is_array($panier)) {
            $panier = [];
        }

        // Obtenir l'ID de l'article
        $id = $article->getId();

        // Vérifier si l'article existe déjà dans le panier
        if (isset($panier[$id])) {
            // Incrémenter la quantité si l'article est déjà présent dans le panier
            $panier[$id]++;
        } else {
            // Ajouter l'article avec une quantité de 1 s'il n'est pas déjà dans le panier
            $panier[$id] = 1;
        }

        // Décrémenter la quantité disponible de l'article ajouté
        $article->setNbArticle($article->getNbArticle() - 1);
        
        // Enregistrer le panier mis à jour dans la session
        $session->set("panier", $panier);

        // Enregistrer les changements dans la base de données
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($article);
        $entityManager->flush();

        // Rediriger vers la page d'accueil ou toute autre page appropriée
        return $this->redirectToRoute("app_article_indexFront");
    }

    #[Route('/addback/{id}', name: 'add_panier_back')]
    public function addback(Article $article, SessionInterface $session)
    {
        // Récupérer le panier depuis la session
        $panier = $session->get("panier", []);

        // Assurer que $panier est un tableau
        if (!is_array($panier)) {
            $panier = [];
        }

        // Obtenir l'ID de l'article
        $id = $article->getId();

        // Vérifier si l'article existe déjà dans le panier
        if (isset($panier[$id])) {
            // Incrémenter la quantité si l'article est déjà présent dans le panier
            $panier[$id]++;
        } else {
            // Ajouter l'article avec une quantité de 1 s'il n'est pas déjà dans le panier
            $panier[$id] = 1;
        }

        // Décrémenter la quantité disponible de l'article ajouté
        $article->setNbArticle($article->getNbArticle() - 1);
        
        // Enregistrer le panier mis à jour dans la session
        $session->set("panier", $panier);

        // Enregistrer les changements dans la base de données
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($article);
        $entityManager->flush();
        
        // Rediriger vers la page d'accueil ou toute autre page appropriée
        return $this->redirectToRoute("app_panier");
    }


    
    #[Route('/remove/{id}', name: 'remove')]
    public function remove(Article $article, SessionInterface $session)
    {
        // Récupérer le panier depuis la session
        $panier = $session->get("panier", []);
    
        // Assurer que $panier est un tableau
        if (!is_array($panier)) {
            $panier = [];
        }
    
        // Obtenir l'ID de l'article
        $id = $article->getId();
    
        // Vérifier si l'article existe déjà dans le panier
        if (isset($panier[$id])) {
            // Incrémenter la quantité si l'article est déjà présent dans le panier
            if($panier[$id] > 1) {
            $panier[$id]--;
            }else {
                unset ($panier[$id]);
            }
        }
        
        // Décrémenter la quantité disponible de l'article ajouté
        $article->setNbArticle($article->getNbArticle() + 1);
    
        // Enregistrer le panier mis à jour dans la session
        $session->set("panier", $panier);

        // Enregistrer les changements dans la base de données
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($article);
        $entityManager->flush();
    
        // Rediriger vers la page d'accueil ou toute autre page appropriée
        return $this->redirectToRoute("app_panier");
    }


    
    #[Route('/delete/{id}', name: 'delete')]
public function delete(Article $article, SessionInterface $session)
{
    // Récupérer le panier depuis la session
    $panier = $session->get("panier", []);

    // Assurer que $panier est un tableau
    if (!is_array($panier)) {
        $panier = [];
    }

    // Obtenir l'ID de l'article
    $id = $article->getId();

    // Vérifier si l'article existe déjà dans le panier
    if (!empty($panier[$id])) {
        // Supprimer l'article du panier
        unset($panier[$id]);
        
        // Restaurer le stock de l'article en incrémentant le nombre d'articles disponibles
        $article->setNbArticle($article->getNbArticle() + 1);
        
        // Enregistrer les changements dans la base de données
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($article);
        $entityManager->flush();
    }

    // Enregistrer le panier mis à jour dans la session
    $session->set("panier", $panier);

    // Rediriger vers la page du panier
    return $this->redirectToRoute("app_panier");
}

}
