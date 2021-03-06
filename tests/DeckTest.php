<?php

use Mockery as m;
use NoelDavies\Cards\Deck;
use NoelDavies\Cards\Contracts\CardProvider;

class DeckTest extends PHPUnit_Framework_TestCase {

	public function setUp()
	{
	}

	protected function tearDown() {
        \Mockery::close();
    }

	public function testDeckCount()
	{
		$deck = new Deck;

		$this->assertEquals(52, $deck->count());
	}

	public function testDraw()
	{
		$deck = new Deck;
		$c = $deck->draw();

		$this->assertInstanceOf('NoelDavies\Cards\Card', $c);
		$this->assertEquals(51, $deck->count());
		$this->assertEquals(1, $deck->countDrawn());
	}

	/**
     * @expectedException UnderflowException
     */
    public function testDeckHadNoCardsException()
    {

		$deck = new Deck(new EmptyCardProvider);
		$deck->draw();
	}

	 public function testDrawHand()
    {

		$deck = new Deck();

		$h = $deck->drawHand();
		$this->assertCount(1,$h);

		$hh = $deck->drawHand(10);
		$this->assertCount(10,$hh);

	}

    public function testDrawCard()
    {

		$deck = new Deck();

		$this->assertCount(52,$deck->getCards() );
		$this->assertCount(0,$deck->getDrawnCards() );
		$deck->draw();
		$deck->draw();
		$this->assertCount(50,$deck->getCards() );
		$this->assertCount(2,$deck->getDrawnCards() );
	}

	public function testShuffleResets()
    {

		$deck = new Deck();
		$deck->draw();
		$deck->draw();
		$this->assertCount(50,$deck->getCards() );
		$this->assertCount(2,$deck->getDrawnCards() );

		$deck->shuffle();

		$this->assertCount(52,$deck->getCards() );
		$this->assertCount(0,$deck->getDrawnCards() );
	}

	public function testShuffleShuffles()
    {

		$deck = new Deck();
		$shuffle = m::mock('NoelDavies\Cards\Contracts\Shuffleable')->shouldReceive('shuffle')->once()->andReturn(true)->getMock();
		$deck->setShuffler($shuffle);

		$v = $deck->shuffle();

		$this->assertTrue($v);
    }
}

class EmptyCardProvider implements CardProvider{

	public function getCards(){
			return	[];
	}
}
