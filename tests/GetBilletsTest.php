<?php

namespace SkiLoisirsDiffusion\Tests;

use Mockery;
use SkiLoisirsDiffusion\SkiLoisirsDiffusion;

/**
 * will test the get_billet sld function.
 *
 * @todo incomplete
 */
class GetBilletsTest extends BaseTestCase
{
    public const COMMANDE_NON_FINALISEE = 'c5944e7e-6e3c-40c3-8682-9c86552e10f1';

    /** @var int $orderNumber */
    protected $orderNumber;

    /** @var SkiLoisirsDiffusion\SkiLoisirsDiffusion $SLDFactory */
    protected $SLDFactory;

    /** @var \Mockery $mocked */
    protected $mocked;

    /** @var \SkiLoisirsDiffusion\Datasets\CreateOrderDataset $orderDataset */
    protected $orderDataset;

    /** @var \SkiLoisirsDiffusion\Datasets\InsertOrderLineDataset $insertOrderLineDataset */
    protected $insertOrderLineDataset;

    public function setUp() :void
    {
        parent::setUp();

        $this->orderDataset = $this->getOrderDataSet();

        if (sldconfig('use_real_data') == 1) {
            $this->SLDFactory = SkiLoisirsDiffusion::create(sldconfig('sld_domain_url'), sldconfig('sld_partenaire_id'));
            $this->orderNumber = $this->SLDFactory->CREATION_COMMANDE($this->orderDataset);
        } else {
            $this->mocked = Mockery::mock(SkiLoisirsDiffusion::class)->makePartial();
            $this->mocked->shouldReceive('CREATION_COMMANDE')->with($this->orderDataset)->once()->andReturn(25457);
            $this->orderNumber = $this->mocked->CREATION_COMMANDE($this->orderDataset);
        }

        $this->insertOrderLineDataset = $this->getInsertOrderLineDataset($this->orderNumber, 'AQAMNA01ADEBR', 10.0);
        if (sldconfig('use_real_data') == 1) {
            SkiLoisirsDiffusion::create(sldconfig('sld_domain_url'), sldconfig('sld_partenaire_id'))
                ->INSERTION_LIGNE_COMMANDE($this->orderNumber, $this->insertOrderLineDataset);
        } else {
            $this->mocked->shouldReceive('INSERTION_LIGNE_COMMANDE')->with($this->orderNumber, $this->insertOrderLineDataset)->once()->andReturn(true);
            $this->mocked->INSERTION_LIGNE_COMMANDE($this->orderNumber, $this->insertOrderLineDataset);
        }
    }

    public function tearDown(): void
    {
        Mockery::close();
    }

    /** @test */
    public function get_billets_is_ok()
    {
        if (sldconfig('use_real_data') == 1) {
            /** getting avaihlable order status from remote */
            $pdfData = $this->SLDFactory->GET_BILLETS($this->orderNumber);
        } else {
            /** getting avaihlable order status from local */
            $this->mocked->shouldReceive('GET_BILLETS')->with($this->orderNumber)->once()->andReturn('VBERi0xLjYNCjEgMCBvYmoNCjw8IA0KL0xlbmd0aCA1OTA0DQovRmlsdGVyIC9GbGF0ZURlY29kZQ0KPj4NCnN0cmVhbQ0KSdDtzoYW');
            $pdfData = $this->mocked->GET_BILLETS($this->orderNumber);
        }
        $this->assertNotNull($pdfData);
    }
}
