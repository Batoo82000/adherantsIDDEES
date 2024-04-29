<?php

namespace App\Controller;

use AllowDynamicProperties;
use App\Classe\Search;
use App\Entity\Adherants;
use App\Form\SearchType;
use App\Repository\AdherantsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[AllowDynamicProperties] class AdherantsController extends AbstractController
{

    public function __construct(EntityManagerInterface $entityManager) // Dans le constructeur de la classe, une dépendance de type EntityManagerInterface est injectée. Cela signifie que chaque instance de ProductController doit recevoir un objet EntityManagerInterface lors de sa création.
    {
        $this->entitymanager = $entityManager;
    }

    #[Route('/adherant', name: 'adherants')]
    public function index(EntityManagerInterface $entityManager, AdherantsRepository $adherants, Request $request): Response
    {
        $totalAdherents = $entityManager->getRepository(Adherants::class)->count([]);
        $adherantsCount = $entityManager->getRepository(Adherants::class)->findAll();
        $search = new Search();
        $form = $this->createForm(SearchType::class, $search);
        $form->handleRequest($request);
        $adherantsLessThanOneYear = [];
        $adherantsMoreThanOneYear = [];

        foreach ($adherantsCount as $adherant) {
            $startDate = $adherant->getDateAdhesion();
            $difference = (new \DateTime())->diff($startDate)->days;

            if ($difference <= 365) {
                $adherantsLessThanOneYear[] = $adherant;
            } else {
                $adherantsMoreThanOneYear[] = $adherant;
            }
        }
        if($form->isSubmitted() && $form->isValid() && !empty($search->string)) {
            $adherants = $this->entitymanager->getRepository(Adherants::class)->searchByName($search);
            return $this->render('adherants/index.html.twig', [
                'adherantsLessThanOneYear' => $adherantsLessThanOneYear,
                'adherantsMoreThanOneYear' => $adherantsMoreThanOneYear,
                'form'=>$form->createView(),
                'total_adherents' => $totalAdherents,
                'adherants' => $adherants,
            ]);
        }
        else {
        return $this->render('adherants/index.html.twig', [
            'adherantsLessThanOneYear' => $adherantsLessThanOneYear,
            'adherantsMoreThanOneYear' => $adherantsMoreThanOneYear,
            'form'=>$form->createView(),
            'total_adherents' => $totalAdherents,
            'adherants' => [],
        ]);
        }
    }
}
