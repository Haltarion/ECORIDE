<?php

namespace App\Service;

use App\Entity\User;
use App\Repository\VoitureRepository;

class VehiculeInfoService

{
    private VoitureRepository $voitureRepository;

    public function __construct(VoitureRepository $voitureRepository)
    {
        $this->voitureRepository = $voitureRepository;
    }

    /**
     * Retourne une liste d'infos véhicules (liste vide si aucun véhicule).
     */
    public function getVoituresInfosByUser(User $user): array
    {
        $voitures = $this->voitureRepository->findByUser($user);

        // Déclaration de la variable du tableau des infos véhicules
        $voituresInfos = [];

        foreach ($voitures as $voiture) {
            $voituresInfos[] = [
                'immatriculation' => $voiture->getImmatriculation(),
                'datePremiereImmatriculation' => $voiture->getDatePremiereImmatriculation(),
                'marque' => $voiture->getMarque(),
                'modele' => $voiture->getModele(),
                'electrique' => $voiture->getElectrique(),
                'couleur' => $voiture->getCouleur(),
                'nbPlaceDispo' => $voiture->getNbPlaceDispo(),
            ];
        }

        return $voituresInfos;
    }
}