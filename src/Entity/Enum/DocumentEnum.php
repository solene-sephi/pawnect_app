<?php

namespace App\Entity\Enum;

enum DocumentEnum: string
{
    case ID_CARD = 'id_card';                // Carte d'identité
    case PASSPORT = 'passport';              // Passeport
    case PROOF_OF_ADDRESS = 'proof_of_address'; // Justificatif de domicile
    case VETERINARY_CERTIFICATE = 'veterinary_certificate'; // Certificat vétérinaire
    case ADOPTION_APPLICATION = 'adoption_application'; // Demande d'adoption
    case FOSTER_FAMILY_APPLICATION = 'foster_family_application'; // Demande de famille d'accueil
    case MEDICAL_HISTORY = 'medical_history'; // Dossier médical de l'animal
    case CONTRACT = 'contract';              // Contrat (d'adoption, de famille d'accueil)
    case POLICE_CHECK = 'police_check';      // Vérification de casier judiciaire
    case INSURANCE = 'insurance';            // Assurance
    case VACCINATION_RECORD = 'vaccination_record'; // Carnet de vaccination
}