<?php

namespace SkiLoisirsDiffusion\Tests;

use SkiLoisirsDiffusion\Datasets\CeDatasetTable;
use SkiLoisirsDiffusion\Datasets\DatasetField;
use SkiLoisirsDiffusion\Datasets\DatasetTable;
use SkiLoisirsDiffusion\Datasets\MakeDataset;
use SkiLoisirsDiffusion\SkiLoisirsDiffusion;
use SkiLoisirsDiffusion\Tests\Factory\OrderFactory;
use SkiLoisirsDiffusion\Tests\Factory\UserFactory;
use stdClass;

class CreateOrderDatasetTest extends BaseTestCase
{
    protected $user;
    protected $order;
    protected $signature;

    /** @var \Skiloisirs\Datasets\DatasetTable $ceDataSetTable */
    protected $ceDataSetTable;

    /** @var \Skiloisirs\Datasets\DatasetTable $userDatasetTable */
    protected $userDatasetTable;

    /** @var \Skiloisirs\Datasets\DatasetTable $orderDataSetTable */
    protected $orderDataSetTable;

    /** @var \Skiloisirs\Datasets\DatasetTable $signatureDataSetTable */
    protected $signatureDataSetTable;

    /** @var \Skiloisirs\Datasets\MakeDataset $orderDataset */
    protected $orderDataset;

    public function setUp() :void
    {
        parent::setUp();
        $this->ceDataSetTable = CeDatasetTable::create();
        $this->userDatasetTable = $this->getUserDatasetTable();
        $this->orderDataSetTable = $this->getOrderDatasetTable();
        $this->signatureDataSetTable = $this->getSignatureDatasetTable();

        $this->orderDataset = MakeDataset::init()->addDatasetTables(
            [
                $this->ceDataSetTable,
                $this->userDatasetTable,
                $this->orderDataSetTable,
                $this->signatureDataSetTable,
            ]
        )->render();
    }

    /** @test */
    public function order_dataset_schema_is_ok()
    {
        $this->assertEquals($this->expectedSchema(), $this->orderDataset->schema());
    }

    /** @test */
    public function order_dataset_body_is_ok()
    {
        $this->assertEquals($this->expectedBody(), $this->orderDataset->body());
    }

    /** @test */
    public function create_order_dataset_is_stdclass()
    {
        $this->assertInstanceOf(stdClass::class, $this->orderDataset->dataset());
        $this->assertIsString($this->orderDataset->dataset()->schema);
        $this->assertEquals($this->expectedSchema(), $this->orderDataset->dataset()->schema);
        $this->assertIsString($this->orderDataset->dataset()->any);
        $this->assertEquals($this->expectedBody(), $this->orderDataset->dataset()->any);
    }

    /** @test */
    public function creation_commande_is_ok()
    {
        $orderNumber = SkiLoisirsDiffusion::create(sldconfig('sld_domain_url'), sldconfig('sld_partenaire_id'))
            ->CREATION_COMMANDE($this->orderDataset->dataset());
        $this->assertGreaterThan(0, $orderNumber);
    }

    public function getUserDatasetTable(): DatasetTable
    {
        $this->user = UserFactory::create();
        return DatasetTable::create('utilisateur')
            ->addDatasetFields(
                [
                    DatasetField::create('id_partenaire', 'string', $this->user['id_partenaire']),
                    DatasetField::create('utilisateurs_societe', 'string', $this->user['utilisateurs_societe'], 0, false),
                    DatasetField::create('utilisateurs_civilite', 'string', $this->user['utilisateurs_civilite'], 0, false),
                    DatasetField::create('utilisateurs_nom', 'string', $this->user['utilisateurs_nom']),
                    DatasetField::create('utilisateurs_prenom', 'string', $this->user['utilisateurs_prenom']),
                    DatasetField::create('utilisateurs_telephone', 'string', $this->user['utilisateurs_telephone']),
                    DatasetField::create('utilisateurs_portable', 'string', $this->user['utilisateurs_portable']),
                    DatasetField::create('utilisateurs_fax', 'string', $this->user['utilisateurs_fax'], 0, false),
                    DatasetField::create('utilisateurs_email', 'string', $this->user['utilisateurs_email']),
                    DatasetField::create('utilisateurs_adresse_nom', 'string', $this->user['utilisateurs_adresse_nom']),
                    DatasetField::create('utilisateurs_adresse1', 'string', $this->user['utilisateurs_adresse1']),
                    DatasetField::create('utilisateurs_adresse2', 'string', $this->user['utilisateurs_adresse2']),
                    DatasetField::create('utilisateurs_codepostal', 'string', $this->user['utilisateurs_codepostal']),
                    DatasetField::create('utilisateurs_ville', 'string', $this->user['utilisateurs_ville']),
                    DatasetField::create('utilisateurs_pays', 'string', $this->user['utilisateurs_pays']),
                    DatasetField::create('utilisateurs_date_naissance', 'dateTime', $this->user['utilisateurs_date_naissance']),
                ]
            );
    }

    public function getOrderDatasetTable(): DatasetTable
    {
        $this->order = OrderFactory::create(
            [
                'code_livraison' => 'LS100G',
                'prix_livraison' => 6.0, // <livraisons_puttc>6,0000</livraisons_puttc>
            ]
        );
        return DatasetTable::create('commande')
            ->addDatasetFields(
                [
                    DatasetField::create('nb_cheques_vacances', 'string', $this->order['nb_cheques_vacances']),
                    DatasetField::create('montant_total_cheques_vacances', 'string', $this->order['montant_total_cheques_vacances']),
                    DatasetField::create('mode_paiement', 'string', $this->order['mode_paiement']),
                    DatasetField::create('prix_livraison', 'decimal', $this->order['prix_livraison']),
                    DatasetField::create('code_livraison', 'string', $this->order['code_livraison']),
                    DatasetField::create('commentaire', 'string', $this->order['commentaire'], 0, false),
                    DatasetField::create('livraison_adresse_societe', 'string', $this->order['livraison_adresse_societe']),
                    DatasetField::create('livraison_adresse_nom', 'string', $this->order['livraison_adresse_nom']),
                    DatasetField::create('livraison_adresse1', 'string', $this->order['livraison_adresse1']),
                    DatasetField::create('livraison_adresse2', 'string', $this->order['livraison_adresse2']),
                    DatasetField::create('livraison_codepostal', 'string', $this->order['livraison_codepostal']),
                    DatasetField::create('livraison_ville', 'string', $this->order['livraison_ville']),
                    DatasetField::create('livraison_pays', 'string', $this->order['livraison_pays'], 0, false),
                    DatasetField::create('url_retour', 'string', $this->order['url_retour'], 0, false),
                    DatasetField::create('url_retour_ok', 'string', $this->order['url_retour_ok'], 0, false),
                    DatasetField::create('url_retour_err', 'string', $this->order['url_retour_err'], 0, false),
                    DatasetField::create('acompte', 'decimal', $this->order['acompte'], 0, false),
                    DatasetField::create('numero_commande_ticketnet', 'string', $this->order['numero_commande_ticketnet'], 0, false),
                    DatasetField::create('frais_gestion_payeur', 'string', $this->order['frais_gestion_payeur'], 0, false),
                    DatasetField::create('frais_port_payeur', 'string', $this->order['frais_port_payeur'], 0, false),
                    DatasetField::create('remise_frais_port', 'decimal', $this->order['remise_frais_port'], 0, false),
                    DatasetField::create('numero_commande_distributeur', 'string', $this->order['numero_commande_distributeur'], 0, false),
                ]
            );
    }

    public function getSignatureDatasetTable(): DatasetTable
    {
        $createSignatureParameters = [
            'code_livraison' => $this->order['code_livraison'],
            'id_partenaire' => $this->user['id_partenaire'],
            'mode_paiement' => $this->order['mode_paiement'],
            'utilisateurs_adresse1' => $this->user['utilisateurs_adresse1'],
            'utilisateurs_adresse_nom' => $this->user['utilisateurs_adresse_nom'],
            'utilisateurs_codepostal' => $this->user['utilisateurs_codepostal'],
            'utilisateurs_email' => $this->user['utilisateurs_email'],
            'utilisateurs_nom' => $this->user['utilisateurs_nom'],
            'utilisateurs_prenom' => $this->user['utilisateurs_prenom'],
            'utilisateurs_ville' => $this->user['utilisateurs_ville'],
            'clef_secrete' => sldconfig('clef_secrete'),
        ];

        $this->signature = generateSignature($createSignatureParameters);
        return DatasetTable::create('signature')
            ->addDatasetFields(
                [
                    DatasetField::create('signature', 'string', $this->signature),
                ]
            );
    }

    protected function expectedBody(): string
    {
        $ce_id = sldconfig('sld_partenaire_id');
        $ce_societe = sldconfig('ce_societe');
        $ce_nom = sldconfig('ce_nom');
        $ce_prenom = sldconfig('ce_prenom');
        $ce_email = sldconfig('ce_email');
        $ce_codepostal = sldconfig('ce_codepostal');
        $ce_ville = sldconfig('ce_ville');
        return <<<EOT
<diffgr:diffgram xmlns:diffgr="urn:schemas-microsoft-com:xml-diffgram-v1" xmlns:msdata="urn:schemas-microsoft-com:xml-msdata">
<NewDataSet xmlns="">
<ce diffgr:id="ce1" msdata:rowOrder="0">
<ce_id>{$ce_id}</ce_id>
<ce_societe>{$ce_societe}</ce_societe>
<ce_civilite></ce_civilite>
<ce_nom>{$ce_nom}</ce_nom>
<ce_prenom>{$ce_prenom}</ce_prenom>
<ce_telephone></ce_telephone>
<ce_portable></ce_portable>
<ce_fax></ce_fax>
<ce_email>{$ce_email}</ce_email>
<ce_adresse_nom></ce_adresse_nom>
<ce_adresse1></ce_adresse1>
<ce_adresse2></ce_adresse2>
<ce_codepostal>{$ce_codepostal}</ce_codepostal>
<ce_ville>{$ce_ville}</ce_ville>
<ce_pays></ce_pays>
</ce>
<utilisateur diffgr:id="utilisateur1" msdata:rowOrder="1">
<id_partenaire>{$this->user['id_partenaire']}</id_partenaire>
<utilisateurs_societe>{$this->user['utilisateurs_societe']}</utilisateurs_societe>
<utilisateurs_civilite>{$this->user['utilisateurs_civilite']}</utilisateurs_civilite>
<utilisateurs_nom>{$this->user['utilisateurs_nom']}</utilisateurs_nom>
<utilisateurs_prenom>{$this->user['utilisateurs_prenom']}</utilisateurs_prenom>
<utilisateurs_telephone>{$this->user['utilisateurs_telephone']}</utilisateurs_telephone>
<utilisateurs_portable>{$this->user['utilisateurs_portable']}</utilisateurs_portable>
<utilisateurs_fax>{$this->user['utilisateurs_fax']}</utilisateurs_fax>
<utilisateurs_email>{$this->user['utilisateurs_email']}</utilisateurs_email>
<utilisateurs_adresse_nom>{$this->user['utilisateurs_adresse_nom']}</utilisateurs_adresse_nom>
<utilisateurs_adresse1>{$this->user['utilisateurs_adresse1']}</utilisateurs_adresse1>
<utilisateurs_adresse2>{$this->user['utilisateurs_adresse2']}</utilisateurs_adresse2>
<utilisateurs_codepostal>{$this->user['utilisateurs_codepostal']}</utilisateurs_codepostal>
<utilisateurs_ville>{$this->user['utilisateurs_ville']}</utilisateurs_ville>
<utilisateurs_pays>{$this->user['utilisateurs_pays']}</utilisateurs_pays>
<utilisateurs_date_naissance>{$this->user['utilisateurs_date_naissance']}</utilisateurs_date_naissance>
</utilisateur>
<commande diffgr:id="commande1" msdata:rowOrder="2">
<nb_cheques_vacances>{$this->order['nb_cheques_vacances']}</nb_cheques_vacances>
<montant_total_cheques_vacances>{$this->order['montant_total_cheques_vacances']}</montant_total_cheques_vacances>
<mode_paiement>{$this->order['mode_paiement']}</mode_paiement>
<prix_livraison>{$this->order['prix_livraison']}</prix_livraison>
<code_livraison>{$this->order['code_livraison']}</code_livraison>
<commentaire>{$this->order['commentaire']}</commentaire>
<livraison_adresse_societe>{$this->order['livraison_adresse_societe']}</livraison_adresse_societe>
<livraison_adresse_nom>{$this->order['livraison_adresse_nom']}</livraison_adresse_nom>
<livraison_adresse1>{$this->order['livraison_adresse1']}</livraison_adresse1>
<livraison_adresse2>{$this->order['livraison_adresse2']}</livraison_adresse2>
<livraison_codepostal>{$this->order['livraison_codepostal']}</livraison_codepostal>
<livraison_ville>{$this->order['livraison_ville']}</livraison_ville>
<livraison_pays>{$this->order['livraison_pays']}</livraison_pays>
<url_retour>{$this->order['url_retour']}</url_retour>
<url_retour_ok>{$this->order['url_retour_ok']}</url_retour_ok>
<url_retour_err>{$this->order['url_retour_err']}</url_retour_err>
<acompte>{$this->order['acompte']}</acompte>
<numero_commande_ticketnet>{$this->order['numero_commande_ticketnet']}</numero_commande_ticketnet>
<frais_gestion_payeur>{$this->order['frais_gestion_payeur']}</frais_gestion_payeur>
<frais_port_payeur>{$this->order['frais_port_payeur']}</frais_port_payeur>
<remise_frais_port>{$this->order['remise_frais_port']}</remise_frais_port>
<numero_commande_distributeur>{$this->order['numero_commande_distributeur']}</numero_commande_distributeur>
</commande>
<signature diffgr:id="signature1" msdata:rowOrder="3">
<signature>{$this->signature}</signature>
</signature>
</NewDataSet>
</diffgr:diffgram>
EOT;
    }

    protected function expectedSchema(): string
    {
        return <<<EOT
<xs:schema xmlns:xs="http://www.w3.org/2001/XMLSchema" xmlns="" xmlns:msdata="urn:schemas-microsoft-com:xml-msdata" id="NewDataSet">
<xs:element name="NewDataSet" msdata:IsDataSet="true" msdata:UseCurrentLocale="true">
<xs:complexType>
<xs:choice minOccurs="0" maxOccurs="unbounded">
<xs:element name="ce">
<xs:complexType>
<xs:sequence>
<xs:element name="ce_id" type="xs:string" minOccurs="0"/>
<xs:element name="ce_societe" type="xs:string" minOccurs="0"/>
<xs:element name="ce_civilite" type="xs:string" minOccurs="0"/>
<xs:element name="ce_nom" type="xs:string" minOccurs="0"/>
<xs:element name="ce_prenom" type="xs:string" minOccurs="0"/>
<xs:element name="ce_telephone" type="xs:string" minOccurs="0"/>
<xs:element name="ce_portable" type="xs:string" minOccurs="0"/>
<xs:element name="ce_fax" type="xs:string" minOccurs="0"/>
<xs:element name="ce_email" type="xs:string" minOccurs="0"/>
<xs:element name="ce_adresse_nom" type="xs:string" minOccurs="0"/>
<xs:element name="ce_adresse1" type="xs:string" minOccurs="0"/>
<xs:element name="ce_adresse2" type="xs:string" minOccurs="0"/>
<xs:element name="ce_codepostal" type="xs:string" minOccurs="0"/>
<xs:element name="ce_ville" type="xs:string" minOccurs="0"/>
<xs:element name="ce_pays" type="xs:string" minOccurs="0"/>
</xs:sequence>
</xs:complexType>
</xs:element>
<xs:element name="utilisateur">
<xs:complexType>
<xs:sequence>
<xs:element name="id_partenaire" type="xs:string" minOccurs="0"/>
<xs:element name="utilisateurs_societe" type="xs:string" minOccurs="0"/>
<xs:element name="utilisateurs_civilite" type="xs:string" minOccurs="0"/>
<xs:element name="utilisateurs_nom" type="xs:string" minOccurs="0"/>
<xs:element name="utilisateurs_prenom" type="xs:string" minOccurs="0"/>
<xs:element name="utilisateurs_telephone" type="xs:string" minOccurs="0"/>
<xs:element name="utilisateurs_portable" type="xs:string" minOccurs="0"/>
<xs:element name="utilisateurs_fax" type="xs:string" minOccurs="0"/>
<xs:element name="utilisateurs_email" type="xs:string" minOccurs="0"/>
<xs:element name="utilisateurs_adresse_nom" type="xs:string" minOccurs="0"/>
<xs:element name="utilisateurs_adresse1" type="xs:string" minOccurs="0"/>
<xs:element name="utilisateurs_adresse2" type="xs:string" minOccurs="0"/>
<xs:element name="utilisateurs_codepostal" type="xs:string" minOccurs="0"/>
<xs:element name="utilisateurs_ville" type="xs:string" minOccurs="0"/>
<xs:element name="utilisateurs_pays" type="xs:string" minOccurs="0"/>
<xs:element name="utilisateurs_date_naissance" type="xs:dateTime" minOccurs="0"/>
</xs:sequence>
</xs:complexType>
</xs:element>
<xs:element name="commande">
<xs:complexType>
<xs:sequence>
<xs:element name="nb_cheques_vacances" type="xs:string" minOccurs="0"/>
<xs:element name="montant_total_cheques_vacances" type="xs:string" minOccurs="0"/>
<xs:element name="mode_paiement" type="xs:string" minOccurs="0"/>
<xs:element name="prix_livraison" type="xs:decimal" minOccurs="0"/>
<xs:element name="code_livraison" type="xs:string" minOccurs="0"/>
<xs:element name="commentaire" type="xs:string" minOccurs="0"/>
<xs:element name="livraison_adresse_societe" type="xs:string" minOccurs="0"/>
<xs:element name="livraison_adresse_nom" type="xs:string" minOccurs="0"/>
<xs:element name="livraison_adresse1" type="xs:string" minOccurs="0"/>
<xs:element name="livraison_adresse2" type="xs:string" minOccurs="0"/>
<xs:element name="livraison_codepostal" type="xs:string" minOccurs="0"/>
<xs:element name="livraison_ville" type="xs:string" minOccurs="0"/>
<xs:element name="livraison_pays" type="xs:string" minOccurs="0"/>
<xs:element name="url_retour" type="xs:string" minOccurs="0"/>
<xs:element name="url_retour_ok" type="xs:string" minOccurs="0"/>
<xs:element name="url_retour_err" type="xs:string" minOccurs="0"/>
<xs:element name="acompte" type="xs:decimal" minOccurs="0"/>
<xs:element name="numero_commande_ticketnet" type="xs:string" minOccurs="0"/>
<xs:element name="frais_gestion_payeur" type="xs:string" minOccurs="0"/>
<xs:element name="frais_port_payeur" type="xs:string" minOccurs="0"/>
<xs:element name="remise_frais_port" type="xs:decimal" minOccurs="0"/>
<xs:element name="numero_commande_distributeur" type="xs:string" minOccurs="0"/>
</xs:sequence>
</xs:complexType>
</xs:element>
<xs:element name="signature">
<xs:complexType>
<xs:sequence>
<xs:element name="signature" type="xs:string" minOccurs="0"/>
</xs:sequence>
</xs:complexType>
</xs:element>
</xs:choice>
</xs:complexType>
</xs:element>
</xs:schema>
EOT;
    }
}
