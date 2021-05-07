<?php

namespace SkiLoisirsDiffusion\Tests;

use SkiLoisirsDiffusion\OrderStatus;

class OrderStatusTest extends BaseTestCase
{
    public function setUp() :void
    {
        parent::setUp();
    }

    /** @test */
    public function order_status_is_working_properly()
    {
        $orderStatus = OrderStatus::init(sldconfig('sld_domain_url'));
        if (sldconfig('use_real_data') == 1) {
            $orderStatus->fromRemote();
        } else {
            $orderStatus->fromLocal();
        }
        $result = $orderStatus->status();

        $this->assertIsArray($result);
        $this->assertGreaterThan(0, count($result));

        array_map(function ($id) use ($result) {
            $this->assertTrue(array_key_exists($id, $result));
        }, [
            'e65715d6-b734-4846-8550-15c60981ae12',
            '6e70a77a-bc9c-49b6-a07d-51fa7fcb53be',
            'c74d90d7-ec72-4fb2-8556-89d6251e8933',
            'c482f6d7-5ea6-48f4-8f0f-2999baf7103e',
            '85c1259a-b9cd-491f-af17-6e8ae30167ce',
            'b4f85f79-1167-4307-a503-c62384b9d653',
            '7ef7c216-7c8c-4a8f-9c90-1861d1bb81a6',
            '166be7dd-f03e-40bf-a5d7-3cc7126363b5',
            'edd486e4-5fc8-4e72-a663-f7dc5c6fbd2c',
            '74777da0-93a4-46ec-870e-2220d40978e6',
            '407ef0cf-596c-40e7-8b04-d74bc5640455',
            'ce396be9-c19d-4965-9181-cba77baa3cd6',
            'c5944e7e-6e3c-40c3-8682-9c86552e10f1',
            'e0d519b5-07e1-427f-888b-a802a8bd84dd',
            '1155b458-8356-4bc8-a86d-43280a38aae4',
            '202d2092-7089-49b0-a881-c722ffe80941',
            '58081e43-f3ca-4da3-a74b-65345ae6e544',
            '5e40967f-0dd6-42b8-be86-9217dff70cb2',
            '84d4e36f-2426-418b-86c8-d6dd7e3c90b0',
            'f5cccf5b-922d-4e20-97aa-cf8f2e690075',
            'f5a46a3c-ed9b-476f-9bb3-021cd6c0efde',
            'f9fd34d5-26a3-4298-baff-70906c98790d',
            'e985be84-fdb6-444d-925a-e4567901e147',
        ]);
    }
}
