<?php

namespace App\Controller;

use App\Repository\ContactRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ContactController extends AbstractController
{
    #[Route('/liste-contacts', name: 'app_listecontacts')]
    public function listContacts(ContactRepository $contactRepository): Response
    {
        // Récupérer tous les contacts
        $contacts = $contactRepository->findAllContacts();

        return $this->render('contact/liste-contacts.html.twig', [
            'contacts' => $contacts,
        ]);
    }
}
