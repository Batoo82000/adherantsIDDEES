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

    #[Route('/', name: 'adherants')]
    public function index(EntityManagerInterface $entityManager, AdherantsRepository $adherants, Request $request): Response
    {

        $adherentsLessThanOneYear = $adherants->countAdherentsLessThanOneYear();
        $adherentsMoreThanOneYear = $adherants->countAdherentsMoreThanOneYear();
        $totalAdherents = $entityManager->getRepository(Adherants::class)->count([]);

        $search = new Search();
        $form = $this->createForm(SearchType::class, $search);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $adherants = $this->entitymanager->getRepository(Adherants::class)->searchByName($search);
        } else {
            $adherants = $this->entitymanager->getRepository(Adherants::class)->findAll();
        }

        return $this->render('adherants/index.html.twig', [
            'adherentsLessThanOneYear' => $adherentsLessThanOneYear,
            'adherentsMoreThanOneYear' => $adherentsMoreThanOneYear,
            'form'=>$form->createView(),
            'total_adherents' => $totalAdherents,
            'adherants' => $adherants,
        ]);
    }
}
