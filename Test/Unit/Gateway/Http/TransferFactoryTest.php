<?php
/**
 * Copyright © 2018 Cardknox Development Inc. All rights reserved.
 * See LICENSE for license details.
 */
namespace Magento\SamplePaymentProvider\Test\Unit\Gateway\Http;

use CardknoxDevelopment\Cardknox\Gateway\Http\TransferFactory;
use Magento\Payment\Gateway\Http\TransferBuilder;
use Magento\Payment\Gateway\Http\TransferInterface;
use CardknoxDevelopment\Cardknox\Gateway\Config\Config;

class TransferFactoryTest extends \PHPUnit_Framework_TestCase
{

    private $transferFactory;
    private $transferMock;
    private $config;

    protected function setUp()
    {
        $this->transferBuilder = $this->getMock(TransferBuilder::class);
        $this->config = $this->getMockBuilder(Config::class)
        ->disableOriginalConstructor()
        ->getMock();

        $this->transferMock = $this->getMock(TransferInterface::class);

        $this->transferFactory = new TransferFactory(
            $this->transferBuilder,
            $this->config
        );
    }

    public function testCreate()
    {
        $request = [
            'parameter' => 'value'
        ];
        $this->transferBuilder->expects($this->once())
            ->method('setBody')
            ->with($request)
            ->willReturnSelf();
        $this->transferBuilder->expects($this::once())
            ->method('setMethod')
            ->with('POST')
            ->willReturnSelf();
        $this->transferBuilder->expects($this::once())
            ->method('shouldEncode')
            ->with(true)
            ->willReturnSelf();
        $this->transferBuilder->expects($this::once())
            ->method('setUri')
            ->with($this->config->GetGatewayUrl())
            ->willReturnSelf();
        $this->transferBuilder->expects($this::once())
            ->method('build')
            ->willReturn($this->transferMock);
        $this->assertEquals($this->transferMock, $this->transferFactory->create($request));
    }
}
