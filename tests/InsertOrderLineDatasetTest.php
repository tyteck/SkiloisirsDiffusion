<?php

namespace SkiLoisirsDiffusion\Tests;

use SkiLoisirsDiffusion\Datasets\CreateOrderDataset;
use SkiLoisirsDiffusion\Datasets\InsertOrderLineDataset;
use SkiLoisirsDiffusion\Datatypes\ArticleDatatype;
use SkiLoisirsDiffusion\Datatypes\EbilletDatatype;
use SkiLoisirsDiffusion\Datatypes\OrderDatatype;
use SkiLoisirsDiffusion\Datatypes\UserDatatype;
use SkiLoisirsDiffusion\SkiLoisirsDiffusion;
use SkiLoisirsDiffusion\Tests\Factory\ArticleFactory;
use SkiLoisirsDiffusion\Tests\Factory\EbilletFactory;
use SkiLoisirsDiffusion\Tests\Factory\OrderFactory;
use SkiLoisirsDiffusion\Tests\Factory\UserFactory;

class InsertOrderLineDatasetTest extends BaseTestCase
{
    protected $user;
    protected $order;
    protected $orderNumber;
    protected $expectedSignature;
    protected $articles = [];
    protected $ebillets = [];
    protected $fraisGestion;

    /** @var \Skiloisirs\Datasets\CreateOrderDataset $orderDataset */
    protected $orderDataset;

    public function setUp() :void
    {
        parent::setUp();

        /** creating datatypes to be used */
        $this->user = UserDatatype::create(UserFactory::create());
        $this->order = OrderDatatype::create(OrderFactory::create());
        
        /** creating signature */
        $this->expectedSignature = $this->makeSignatureFrom($this->user, $this->order, sldconfig('clef_secrete'));
        
        $this->articles[] = ArticleDatatype::create(ArticleFactory::create());
        $this->ebillets[] = EbilletDatatype::create(EbilletFactory::create());

        /** creating order */
        $this->orderNumber = (string)rand(24300, 24400);
        $this->insertOrderLine = InsertOrderLineDataset::init();
    }

    /** @test */
    public function with_article_only_is_ok()
    {
        $this->articles[] = ArticleDatatype::create(ArticleFactory::create());

    }
}
