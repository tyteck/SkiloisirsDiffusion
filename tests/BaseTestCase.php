<?php

namespace SkiLoisirsDiffusion\Tests;

use Carbon\Carbon;
use PHPUnit\Framework\TestCase;
use SkiLoisirsDiffusion\Datasets\ArticleDataset;
use SkiLoisirsDiffusion\Datasets\OrderDataset;
use SkiLoisirsDiffusion\Datasets\SignatureDataset;
use SkiLoisirsDiffusion\Datasets\UserDataset;

class BaseTestCase extends TestCase
{
    public function signatureDatasetParameters():array
    {
        return [
            'code_livraison' => '42',
            'id_partenaire' => sldconfig('sld_partenaire_id'),
            'mode_paiement' => 'FCH',
            'utilisateurs_adresse1' => 'chemin de la charrue endommagée',
            'utilisateurs_adresse1' => 'adresse du chou vert',
            'utilisateurs_adresse_nom' => 'domicile',
            'utilisateurs_codepostal' => '77300',
            'utilisateurs_email' => 'gerard@leroy.com',
            'utilisateurs_nom' => 'leroy',
            'utilisateurs_prenom' => 'gerard',
            'utilisateurs_ville' => 'Tourte la charrue',
            'clef_secrete' => sldconfig('clef_secrete'),
        ];
    }

    public function createSignatureDataset(array $attributes = [])
    {
        return SignatureDataset::create($attributes);
    }

    public function createUserDataset()
    {
        return UserDataset::create($this->expectedUserDatasetBody());
    }

    public function createOrderDataset()
    {
        return OrderDataset::create($this->expectedOrderDatasetBody());
    }

    public function articleDatasetParameters()
    {
        return [
            'code_article' => '',
            'quantite' => '',
            'articles_prix' => '',
            'code_parent' => '',
            'acompte' => '',
            'subvention_montant' => '',
            'subvention_payeur' => '',
            'remise' => '',
            'nature_client_id' => '',
            'categorie_place_code' => '',
            'libelle_article' => '',
            'famille_article' => '',
            'skier_index' => '',
        ];
    }

    public function expectedUserDatasetSchema()
    {
        return [
            'id_partenaire' => 'string',
            'utilisateurs_nom' => 'string',
            'utilisateurs_prenom' => 'string',
            'utilisateurs_telephone' => 'string',
            'utilisateurs_portable' => 'string',
            'utilisateurs_email' => 'string',
            'utilisateurs_adresse1' => 'string',
            'utilisateurs_codepostal' => 'string',
            'utilisateurs_ville' => 'string',
            'utilisateurs_pays' => 'string',
            'date_naissance' => 'dateTime',
        ];
    }

    public function expectedCeDatasetSchema()
    {
        return [
            'ce_id' => 'string',
            'ce_societe' => 'string',
            'ce_nom' => 'string',
            'ce_prenom' => 'string',
            'ce_email' => 'string',
            'ce_codepostal' => 'string',
            'ce_ville' => 'string',
        ];
    }

    public function expectedOrderDatasetSchema()
    {
        return [
            'nb_cheques_vacances' => 'string',
            'montant_total_cheques_vacances' => 'string',
            'mode_paiement' => 'string',
            'prix_livraison' => 'decimal',
            'code_livraison' => 'string',
            'commentaire' => 'string',
            'livraison_adresse_nom' => 'string',
            'livraison_adresse_1' => 'string',
            'livraison_adresse_2' => 'string',
            'livraison_codepostal' => 'string',
            'livraison_ville' => 'string',
            'livraison_pays' => 'string',
            'url_retour' => 'string',
            'url_retour_ok' => 'string',
            'url_retour_err' => 'string',
            'acompte' => 'decimal',
            'numero_commande_ticketnet' => 'string',
        ];
    }

    public function expectedCeDatasetBody()
    {
        return [
            'ce_id' => sldconfig('sld_partenaire_id'),
            'ce_societe' => sldconfig('ce_societe'),
            'ce_nom' => sldconfig('ce_nom'),
            'ce_prenom' => sldconfig('ce_prenom'),
            'ce_email' => sldconfig('ce_email'),
            'ce_codepostal' => sldconfig('ce_codepostal'),
            'ce_ville' => sldconfig('ce_ville'),
        ];
    }

    public function createArticleDataset(array $attributes = [])
    {
        return ArticleDataset::create($attributes);
    }

    public function expectedUserDatasetBody()
    {
        return [
            'id_partenaire' => '42',
            'utilisateurs_nom' => 'Leroy',
            'utilisateurs_prenom' => 'Gilbert',
            'utilisateurs_telephone' => '0606060606',
            'utilisateurs_portable' => '0606060606',
            'utilisateurs_email' => 'gilbert@leroy.com',
            'utilisateurs_adresse1' => 'chemin de la charrue endommagée',
            'utilisateurs_codepostal' => '77300',
            'utilisateurs_ville' => 'Tourte la charrue',
            'utilisateurs_pays' => 'France',
            'utilisateurs_date_naissance' => Carbon::now()->subYears(25)->format('Y-m-d\Th:i:s'),
        ];
    }

    public function expectedOrderDatasetBody()
    {
        return [
            'nb_cheques_vacances' => '1',
            'montant_total_cheques_vacances' => '12',
            'mode_paiement' => 'CB',
            'prix_livraison' => '1.9',
            'code_livraison' => 'AYB',
            'commentaire' => 'not required',
            'livraison_adresse_nom' => 'Gilbert Leroy',
            'livraison_adresse_1' => 'chemin de la charrue endommagée',
            'livraison_adresse_2' => '',
            'livraison_codepostal' => '77300',
            'livraison_ville' => 'Tourte la charrue',
            'livraison_pays' => 'not required',
            'url_retour' => 'not required',
            'url_retour_ok' => 'not required',
            'url_retour_err' => 'not required',
            'acompte' => 'not required',
            'numero_commande_ticketnet' => 'not required',
        ];
    }
}
