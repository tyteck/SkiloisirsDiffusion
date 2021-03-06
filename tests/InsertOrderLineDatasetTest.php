<?php

namespace SkiLoisirsDiffusion\Tests;

use Mockery;
use SkiLoisirsDiffusion\Datasets\CreateOrderDataset;
use SkiLoisirsDiffusion\Datasets\InsertOrderLineDataset;
use SkiLoisirsDiffusion\DatasetTables\ArticleDatasetTable;
use SkiLoisirsDiffusion\DatasetTables\EbilletDatasetTable;
use SkiLoisirsDiffusion\DatasetTables\FraisGestionDatasetTable;
use SkiLoisirsDiffusion\Datatypes\ArticleDatatype;
use SkiLoisirsDiffusion\Datatypes\CeDatatype;
use SkiLoisirsDiffusion\Datatypes\EbilletDatatype;
use SkiLoisirsDiffusion\Datatypes\FraisGestionDatatype;
use SkiLoisirsDiffusion\Datatypes\OrderDatatype;
use SkiLoisirsDiffusion\Datatypes\UserDatatype;
use SkiLoisirsDiffusion\SkiLoisirsDiffusion;
use SkiLoisirsDiffusion\Tests\Factory\ArticleFactory;
use SkiLoisirsDiffusion\Tests\Factory\EbilletFactory;
use SkiLoisirsDiffusion\Tests\Factory\FraisGestionFactory;
use SkiLoisirsDiffusion\Tests\Factory\OrderFactory;
use SkiLoisirsDiffusion\Tests\Factory\UserFactory;
use stdClass;

class InsertOrderLineDatasetTest extends BaseTestCase
{
    /** @var \SkiLoisirsDiffusion\Datatypes\CeDatatype $ce */
    protected $ce;
    /** @var \SkiLoisirsDiffusion\Datatypes\UserDatatype $ce */
    protected $user;
    /** @var \SkiLoisirsDiffusion\Datatypes\OrderDatatype $ce */
    protected $order;
    /** @var int $orderNumber */
    protected $orderNumber;
    /** @var string $expectedSignature */
    protected $expectedSignature;
    /** @var array $datasetTables */
    protected $datasetTables = [];

    protected $article;
    protected $ebillet;
    protected $fraisGestion;

    /** @var \Mockery $mocked */
    protected $mocked;

    /** @var \SkiLoisirsDiffusion\Datasets\InsertOrderLineDataset $insertOrderLineDataset */
    protected $insertOrderLineDataset;

    public function setUp() :void
    {
        parent::setUp();

        /** creating datatypes to be used */
        $this->ce = CeDatatype::create(
            [
                'ce_id' => sldconfig('sld_partenaire_id'),
                'ce_societe' => sldconfig('ce_societe'),
                'ce_civilite' => null,
                'ce_nom' => sldconfig('ce_nom'),
                'ce_prenom' => sldconfig('ce_prenom'),
                'ce_telephone' => null,
                'ce_portable' => null,
                'ce_fax' => null,
                'ce_email' => sldconfig('ce_email'),
                'ce_adresse_nom' => null,
                'ce_adresse1' => null,
                'ce_adresse2' => null,
                'ce_codepostal' => sldconfig('ce_codepostal'),
                'ce_ville' => sldconfig('ce_ville'),
                'ce_pays' => null,
            ]
        );
        $this->user = UserDatatype::create(UserFactory::create());
        $this->order = OrderDatatype::create(OrderFactory::create(
            [
                'code_livraison' => 'LS20G',
                'prix_livraison' => 3.5,
            ]
        ));

        $this->orderDataset = CreateOrderDataset::create($this->ce, $this->user, $this->order, sldconfig('clef_secrete'))->render();

        if (sldconfig('use_real_data') == 1) {
            $this->orderNumber = SkiLoisirsDiffusion::create(sldconfig('sld_domain_url'), sldconfig('sld_partenaire_id'))
                ->CREATION_COMMANDE($this->orderDataset);
        } else {
            $this->mocked = Mockery::mock(SkiLoisirsDiffusion::class)->makePartial();
            $this->mocked->shouldReceive('CREATION_COMMANDE')->with($this->orderDataset)->once()->andReturn(25457);
            $this->orderNumber = $this->mocked->CREATION_COMMANDE($this->orderDataset);
        }

        $this->article = ArticleDatatype::create(ArticleFactory::create(['code_article' => 'ALHAMBRA', 'articles_prix' => 6.5]));
        $this->ebillet = EbilletDatatype::create(EbilletFactory::create());
        $this->fraisGestion = FraisGestionDatatype::create(FraisGestionFactory::create(
            [
                'nb_ebc' => 1,
                'prix_ebc' => 0.5,
                'nb_frais_gestion' => 1,
                'prix_frais_gestion' => 0.5
            ]
        ));

        /** creating order */

        $this->datasetTables[] = ArticleDatasetTable::prepare()->with($this->article);
        $this->datasetTables[] = EbilletDatasetTable::prepare()->with($this->ebillet);
        $this->datasetTables[] = FraisGestionDatasetTable::prepare()->with($this->fraisGestion);

        $this->insertOrderLineDataset = InsertOrderLineDataset::create($this->orderNumber)
            ->addDatasetTables($this->datasetTables)
            ->render();
    }

    public function tearDown(): void
    {
        Mockery::close();
    }

    /** @test */
    public function with_one_article_only_is_ok()
    {
        $this->assertEquals($this->expectedSchema(), $this->insertOrderLineDataset->schema());
        $this->assertEquals($this->expectedBody(), $this->insertOrderLineDataset->body());
        $this->assertInstanceOf(stdClass::class, $this->insertOrderLineDataset->dataset());
    }

    /** @test */
    public function insertion_ligne_commande_is_ok()
    {
        if (sldconfig('use_real_data') == 1) {
            $result = SkiLoisirsDiffusion::create(sldconfig('sld_domain_url'), sldconfig('sld_partenaire_id'))
                ->INSERTION_LIGNE_COMMANDE($this->orderNumber, $this->insertOrderLineDataset);
        } else {
            $this->mocked->shouldReceive('INSERTION_LIGNE_COMMANDE')->with($this->orderNumber, $this->insertOrderLineDataset)->once()->andReturn(true);
            $result = $this->mocked->INSERTION_LIGNE_COMMANDE($this->orderNumber, $this->insertOrderLineDataset);
        }
        $this->assertTrue($result);
    }

    protected function expectedBody(): string
    {
        return <<<EOT
<diffgr:diffgram xmlns:diffgr="urn:schemas-microsoft-com:xml-diffgram-v1" xmlns:msdata="urn:schemas-microsoft-com:xml-msdata">
<NewDataSet xmlns="">
<article diffgr:id="article1" msdata:rowOrder="0">
<code_article>{$this->article->code_article}</code_article>
<quantite>{$this->article->quantite}</quantite>
<articles_prix>{$this->article->articles_prix}</articles_prix>
<code_parent>{$this->article->code_parent}</code_parent>
<acompte>{$this->article->acompte}</acompte>
<subvention_montant>{$this->article->subvention_montant}</subvention_montant>
<subvention_payeur>{$this->article->subvention_payeur}</subvention_payeur>
<remise>{$this->article->remise}</remise>
<nature_client_id>{$this->article->nature_client_id}</nature_client_id>
<categorie_place_code>{$this->article->categorie_place_code}</categorie_place_code>
<libelle_article>{$this->article->libelle_article}</libelle_article>
<famille_article>{$this->article->famille_article}</famille_article>
<skier_index>{$this->article->skier_index}</skier_index>
</article>
<ebillet diffgr:id="ebillet1" msdata:rowOrder="1">
<code_article>{$this->ebillet->code_article}</code_article>
<nom>{$this->ebillet->nom}</nom>
<prenom>{$this->ebillet->prenom}</prenom>
<date>{$this->ebillet->date}</date>
<date_naissance>{$this->ebillet->date_naissance}</date_naissance>
<keycard>{$this->ebillet->keycard}</keycard>
<skier_index>{$this->ebillet->skier_index}</skier_index>
</ebillet>
<frais_gestion diffgr:id="frais_gestion1" msdata:rowOrder="2">
<nb_ebillets>{$this->fraisGestion->nb_ebillets}</nb_ebillets>
<prix_ebillet>{$this->fraisGestion->prix_ebillet}</prix_ebillet>
<nb_ebc>{$this->fraisGestion->nb_ebc}</nb_ebc>
<prix_ebc>{$this->fraisGestion->prix_ebc}</prix_ebc>
<nb_ebr>{$this->fraisGestion->nb_ebr}</nb_ebr>
<prix_ebr>{$this->fraisGestion->prix_ebr}</prix_ebr>
<nb_be>{$this->fraisGestion->nb_be}</nb_be>
<prix_be>{$this->fraisGestion->prix_be}</prix_be>
<nb_etickets>{$this->fraisGestion->nb_etickets}</nb_etickets>
<prix_etickets>{$this->fraisGestion->prix_etickets}</prix_etickets>
<nb_retraits>{$this->fraisGestion->nb_retraits}</nb_retraits>
<prix_retraits>{$this->fraisGestion->prix_retraits}</prix_retraits>
<remise_ebillets>{$this->fraisGestion->remise_ebillets}</remise_ebillets>
<remise_ebc>{$this->fraisGestion->remise_ebc}</remise_ebc>
<remise_ebr>{$this->fraisGestion->remise_ebr}</remise_ebr>
<remise_be>{$this->fraisGestion->remise_be}</remise_be>
<remise_etickets>{$this->fraisGestion->remise_etickets}</remise_etickets>
<remise_retraits>{$this->fraisGestion->remise_retraits}</remise_retraits>
<nb_cartes_cadeaux>{$this->fraisGestion->nb_cartes_cadeaux}</nb_cartes_cadeaux>
<prix_carte_cadeau>{$this->fraisGestion->prix_carte_cadeau}</prix_carte_cadeau>
<remise_cartes_cadeaux>{$this->fraisGestion->remise_cartes_cadeaux}</remise_cartes_cadeaux>
<montant_plafond_commande>{$this->fraisGestion->montant_plafond_commande}</montant_plafond_commande>
<nb_frais_gestion>{$this->fraisGestion->nb_frais_gestion}</nb_frais_gestion>
<prix_frais_gestion>{$this->fraisGestion->prix_frais_gestion}</prix_frais_gestion>
<nb_frais_demat>{$this->fraisGestion->nb_frais_demat}</nb_frais_demat>
<prix_frais_demat>{$this->fraisGestion->prix_frais_demat}</prix_frais_demat>
<nb_frais_papier>{$this->fraisGestion->nb_frais_papier}</nb_frais_papier>
<prix_frais_papier>{$this->fraisGestion->prix_frais_papier}</prix_frais_papier>
</frais_gestion>
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
<xs:element name="article">
<xs:complexType>
<xs:sequence>
<xs:element name="code_article" type="xs:string" minOccurs="0"/>
<xs:element name="quantite" type="xs:string" minOccurs="0"/>
<xs:element name="articles_prix" type="xs:string" minOccurs="0"/>
<xs:element name="code_parent" type="xs:string" minOccurs="0"/>
<xs:element name="acompte" type="xs:string" minOccurs="0"/>
<xs:element name="subvention_montant" type="xs:string" minOccurs="0"/>
<xs:element name="subvention_payeur" type="xs:string" minOccurs="0"/>
<xs:element name="remise" type="xs:string" minOccurs="0"/>
<xs:element name="nature_client_id" type="xs:string" minOccurs="0"/>
<xs:element name="categorie_place_code" type="xs:string" minOccurs="0"/>
<xs:element name="libelle_article" type="xs:string" minOccurs="0"/>
<xs:element name="famille_article" type="xs:string" minOccurs="0"/>
<xs:element name="skier_index" type="xs:string" minOccurs="0"/>
</xs:sequence>
</xs:complexType>
</xs:element>
<xs:element name="ebillet">
<xs:complexType>
<xs:sequence>
<xs:element name="code_article" type="xs:string" minOccurs="0"/>
<xs:element name="nom" type="xs:string" minOccurs="0"/>
<xs:element name="prenom" type="xs:string" minOccurs="0"/>
<xs:element name="date" type="xs:string" minOccurs="0"/>
<xs:element name="date_naissance" type="xs:string" minOccurs="0"/>
<xs:element name="keycard" type="xs:string" minOccurs="0"/>
<xs:element name="skier_index" type="xs:string" minOccurs="0"/>
</xs:sequence>
</xs:complexType>
</xs:element>
<xs:element name="frais_gestion">
<xs:complexType>
<xs:sequence>
<xs:element name="nb_ebillets" type="xs:string" minOccurs="0"/>
<xs:element name="prix_ebillet" type="xs:string" minOccurs="0"/>
<xs:element name="nb_ebc" type="xs:string" minOccurs="0"/>
<xs:element name="prix_ebc" type="xs:string" minOccurs="0"/>
<xs:element name="nb_ebr" type="xs:string" minOccurs="0"/>
<xs:element name="prix_ebr" type="xs:string" minOccurs="0"/>
<xs:element name="nb_be" type="xs:string" minOccurs="0"/>
<xs:element name="prix_be" type="xs:string" minOccurs="0"/>
<xs:element name="nb_etickets" type="xs:string" minOccurs="0"/>
<xs:element name="prix_etickets" type="xs:string" minOccurs="0"/>
<xs:element name="nb_retraits" type="xs:string" minOccurs="0"/>
<xs:element name="prix_retraits" type="xs:string" minOccurs="0"/>
<xs:element name="remise_ebillets" type="xs:string" minOccurs="0"/>
<xs:element name="remise_ebc" type="xs:string" minOccurs="0"/>
<xs:element name="remise_ebr" type="xs:string" minOccurs="0"/>
<xs:element name="remise_be" type="xs:string" minOccurs="0"/>
<xs:element name="remise_etickets" type="xs:string" minOccurs="0"/>
<xs:element name="remise_retraits" type="xs:string" minOccurs="0"/>
<xs:element name="nb_cartes_cadeaux" type="xs:string" minOccurs="0"/>
<xs:element name="prix_carte_cadeau" type="xs:string" minOccurs="0"/>
<xs:element name="remise_cartes_cadeaux" type="xs:string" minOccurs="0"/>
<xs:element name="montant_plafond_commande" type="xs:string" minOccurs="0"/>
<xs:element name="nb_frais_gestion" type="xs:string" minOccurs="0"/>
<xs:element name="prix_frais_gestion" type="xs:string" minOccurs="0"/>
<xs:element name="nb_frais_demat" type="xs:string" minOccurs="0"/>
<xs:element name="prix_frais_demat" type="xs:string" minOccurs="0"/>
<xs:element name="nb_frais_papier" type="xs:string" minOccurs="0"/>
<xs:element name="prix_frais_papier" type="xs:string" minOccurs="0"/>
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
