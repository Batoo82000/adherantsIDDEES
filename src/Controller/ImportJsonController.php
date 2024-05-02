<?php

namespace App\Controller;

use App\Entity\Adherants;
use App\Entity\Site;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ImportJsonController extends AbstractController
{
    /**
     * @throws \Exception
     */
    #[Route('/import-json', name: 'import_json')]
public function importJson(EntityManagerInterface $entityManager): Response
{
// Lire le contenu du fichier JSON et le décoder en un tableau associatif PHP
$jsonContent = file_get_contents('../adherents.json');
$dataArray = json_decode($jsonContent, true);

// Parcourir le tableau et créer de nouveaux objets Adherants
foreach ($dataArray as $data) {
$adherant = new Adherants();
$adherant->setNom($data['nom']);
$adherant->setPrenom($data['prenom']);
$adherant->setAdresse($data['adresse']);
$adherant->setCodePostal($data['codePostal']);
$adherant->setVille($data['ville']);
$adherant->setTelephone($data['telephone']);
$adherant->setEmail($data['email']);
$adherant->setDateAdhesion(new \DateTimeImmutable($data['dateAdhesion']));
$adherant->setCotisation($data['cotisation']);
$adherant->setLieuCotisation($data['lieuCotisation']);

// Récupérer l'objet Site correspondant et l'assigner à l'objet Adherants
$site = $entityManager->getRepository(Site::class)->findOneBy(['nom' => $data['site']]);
if ($site instanceof Site) {
$adherant->setSite($site);
}

// Enregistrer l'objet Adherants dans la base de données
$entityManager->persist($adherant);
}

// Exécuter les requêtes d'insertion en une seule fois
$entityManager->flush();

// Retourner une réponse JSON indiquant que l'importation a réussi
return new JsonResponse(['success' => true]);
}
}
