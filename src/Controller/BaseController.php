<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\ContactType;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Contact;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\ContactRepository;
use App\Repository\CategorieRepository;
use App\Entity\Categorie;
use App\Form\ModifierCategorieType;
use App\Form\SupprimerCategorieType;  

class BaseController extends AbstractController 
{
    #[Route('/', name: 'app_accueil')]
    public function index(): Response 
    {
        return $this->render('base/index.html.twig', []);
    }

    #[Route('/a-propos', name: 'app_apropos')]
    public function apropos(): Response 
    {
        return $this->render('base/a_propos.html.twig', []);
    }

    #[Route('/categorie', name: 'app_categorie')]
    public function categorie(): Response 
    {
        return $this->render('categorie/categorie.html.twig', []);
    }

    #[Route('/mention-legale', name: 'app_mentionlegal')]
    public function mentionlegal(): Response 
    {
        return $this->render('base/mention_legal.html.twig', []);
    }
    #[Route('/liste-categories', name: 'app_liste_categories', methods: ['GET', 'POST'])]
    public function listeCategories(Request $request, CategorieRepository $categorieRepository, EntityManagerInterface $em): Response
    {
        // Récupère toutes les catégories
        $categories = $categorieRepository->findAll();
    
        // Créez un formulaire pour la suppression (si nécessaire, remplacez par le bon formulaire)
        $form = $this->createForm(SupprimerCategorieType::class, null, [
            'categories' => $categories,
        ]);
    
        // Gérer la requête du formulaire
        $form->handleRequest($request);
    
        // Si le formulaire est soumis et valide
        if ($form->isSubmitted() && $form->isValid()) {
            $selectedCategories = $form->get('categories')->getData();
    
            foreach ($selectedCategories as $categorie) {
                $em->remove($categorie);
            }
    
            $em->flush();
            $this->addFlash('notice', 'Catégories supprimées avec succès');
    
            return $this->redirectToRoute('app_liste_categories');
        }
    
        // Passer les catégories et le formulaire à la vue
        return $this->render('categorie/liste-categories.html.twig', [
            'categories' => $categories,
            'form' => $form->createView(), // Ici, nous passons le formulaire à la vue
        ]);
    }
    
    
    #[Route('/contact', name: 'app_contact')]
    public function contact(Request $request, EntityManagerInterface $em): Response 
    {
        $contact = new Contact();
        $form = $this->createForm(ContactType::class, $contact);

        if ($request->isMethod('POST')) {
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                $contact->setDateEnvoi(new \DateTime());
                $em->persist($contact);
                $em->flush();
                $this->addFlash('notice', 'Message envoyé');

                return $this->redirectToRoute('app_contact');
            }
        }

        return $this->render('contact/contact.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
