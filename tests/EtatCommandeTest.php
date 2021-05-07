<?php

namespace SkiLoisirsDiffusion\Tests;

use Mockery;
use SkiLoisirsDiffusion\Datasets\CreateOrderDataset;
use SkiLoisirsDiffusion\Datasets\InsertOrderLineDataset;
use SkiLoisirsDiffusion\DatasetTables\ArticleDatasetTable;
use SkiLoisirsDiffusion\DatasetTables\EbilletDatasetTable;
use SkiLoisirsDiffusion\DatasetTables\FraisGestionDatasetTable;
use SkiLoisirsDiffusion\Datatypes\ArticleDatatype;
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

class EtatCommandeTest extends BaseTestCase
{
    public const COMMANDE_NON_FINALISEE = 'c5944e7e-6e3c-40c3-8682-9c86552e10f1';
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

    /** @var SkiLoisirsDiffusion\SkiLoisirsDiffusion $SLDFactory */
    protected $SLDFactory;

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
        $this->ce = $this->ceDatatypeFromConfig();
        $this->user = UserDatatype::create(UserFactory::create());
        $this->order = OrderDatatype::create(OrderFactory::create(
            [
                'code_livraison' => 'LS20G',
                'prix_livraison' => 3.5,
            ]
        ));

        $this->orderDataset = CreateOrderDataset::create($this->ce, $this->user, $this->order, sldconfig('clef_secrete'))->render();

        if (sldconfig('use_real_data') == 1) {
            $this->SLDFactory = SkiLoisirsDiffusion::create(sldconfig('sld_domain_url'), sldconfig('sld_partenaire_id'));
            $this->orderNumber = $this->SLDFactory->CREATION_COMMANDE($this->orderDataset);
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
    public function with_one_line_passation_commande_is_ok()
    {
        if (sldconfig('use_real_data') == 1) {
            /** getting avaihlable order status from remote */
            $etatCommande = $this->SLDFactory->ETAT_COMMANDE($this->orderNumber);
        } else {
            /** getting avaihlable order status from local */
            $this->mocked->shouldReceive('ETAT_COMMANDE')->with($this->orderNumber)->once()->andReturn(self::COMMANDE_NON_FINALISEE);
            $etatCommande = $this->mocked->ETAT_COMMANDE($this->orderNumber);
        }
        $this->assertEquals(self::COMMANDE_NON_FINALISEE, $etatCommande);
    }
}
