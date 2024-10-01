<?php

namespace App\Controller;

use App\Entity\Categorie;
use App\Form\CategorieType;
use App\Repository\CategorieRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\ModifierCategorieType;
use App\Form\SupprimerCategorieType; 



class CategorieController extends AbstractController
{
    #[Route('/categorie/ajouter', name: 'app_categorie_ajouter')]
    public function ajouterCategorie(Request $request, EntityManagerInterface $em): Response
    {
        $categorie = new Categorie();

        // Création du formulaire
        $form = $this->createForm(CategorieType::class, $categorie);

        // Traitement de la requête HTTP
        $form->handleRequest($request);

        // Si le formulaire est soumis et valide, on enregistre la catégorie
        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($categorie);
            $em->flush();

            // Ajout d'un message de confirmation
            $this->addFlash('success', 'La catégorie a bien été ajoutée.');

            // Redirection vers la liste des catégories
            return $this->redirectToRoute('app_categories_liste');
        }

        // Affichage du formulaire dans la vue
        return $this->render('categorie/categorie.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/categories', name: 'app_categories_liste')]
    public function listerCategories(CategorieRepository $categorieRepository): Response
    {
        // Récupère toutes les catégories triées par ordre alphabétique sur le libellé
        $categories = $categorieRepository->findBy([], ['libelle' => 'ASC']);

        return $this->render('categorie/liste-categorie.html.twig', [
            'categories' => $categories,
        ]);
    }

    #[Route('/modifier-categorie/{id}', name: 'app_modifier_categorie')]
public function modifierCategorie(Request $request, Categorie $categorie, EntityManagerInterface $em): Response
{
    // Créer le formulaire pour modifier la catégorie
    $form = $this->createForm(ModifierCategorieType::class, $categorie);

    // Traiter la requête (POST)
    $form->handleRequest($request);

    // Si le formulaire est soumis et valide, enregistrer les modifications
    if ($form->isSubmitted() && $form->isValid()) {
        $em->flush(); // Pas besoin de persist, car la catégorie existe déjà
        $this->addFlash('notice', 'Catégorie modifiée avec succès');
        
        // Rediriger vers la liste des catégories après modification
        return $this->redirectToRoute('app_categories_liste');
    }

    // Si la requête n'est pas un POST ou si le formulaire n'est pas valide, afficher le formulaire
    return $this->render('categorie/modifier-categorie.html.twig', [
        'form' => $form->createView(),
    ]);
}

#[Route('/supprimer-categorie/{id}', name: 'app_supprimer_categorie')]
public function supprimerCategorie(Request $request, Categorie $categorie, EntityManagerInterface $em): Response
{
    if ($categorie !== null) {
        // Suppression de la catégorie
        $em->remove($categorie);
        $em->flush();

        // Ajout d'un message de confirmation
        $this->addFlash('notice', 'Catégorie supprimée');
    }

    // Redirection vers la liste des catégories après suppression
    return $this->redirectToRoute('app_categories_liste');
}


}
