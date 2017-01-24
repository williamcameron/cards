<?php
use NoelDavies\Cards;
use NoelDavies\Cards\Card;
use NoelDavies\Cards\Suit;

class CardsTest extends PHPUnit_Framework_TestCase {

	/**
     * @expectedException InvalidArgumentException
     */
    public function testConstructException()
    {
		$card = new Card(123, Suit::club());
    }

	public function testCardSuit()
	{
		$suit = Suit::club();

		$card = new Card(Card::ACE, $suit);

		$this->assertEquals($card->suit()->value(), $suit->value());
		$this->assertEquals($card->suit()->name(), $suit->name());
		$this->assertEquals($card->suitName(), $suit->name());
	}

	public function testAceCard()
	{
		$card = new Card(Card::ACE, Suit::diamond());
		$this->assertTrue($card->isAce());
		$this->assertEquals(Card::ACE, $card->value());

		//negate the test too
		$card = new Card(2, Suit::diamond());
		$this->assertFalse($card->isAce());
	}

	public function testFaceCard()
	{
		$card = new Card(Card::KING, Suit::diamond());
		$this->assertTrue($card->isKing());
		$this->assertTrue($card->isFaceCard());

		$card = new Card(Card::QUEEN, Suit::diamond());
		$this->assertTrue($card->isQueen());
		$this->assertTrue($card->isFaceCard());

		$card = new Card(Card::JACK, Suit::diamond());
		$this->assertTrue($card->isJack());
		$this->assertTrue($card->isFaceCard());

	}

	public function testNotFaceCard()
	{
		$card = new Card(5, Suit::diamond());
		$this->assertFalse($card->isKing());
		$this->assertFalse($card->isQueen());
		$this->assertFalse($card->isJack());
		$this->assertFalse($card->isFaceCard());

	}

	public function testPrintingACardGivesFriendlyName()
    {
        $card = new Card(5, Suit::diamond());

        $this->assertEquals("5 of diamonds", (string)$card);
    }

    public function testNumericKeyReturnsCorrectForNumberCard()
    {
        $card = new Card(5, Suit::club(false));
        $this->assertEquals(5, $card->numericKey());
    }
    public function testNumericKeyReturnsCorrectForAceCard()
    {
        $ace = 11;

        $card = new Card(Card::ACE, Suit::diamond(false));
        $this->assertEquals($ace, $card->numericKey());
    }
    public function testNumericKeyReturnsCorrectForFaceCard()
    {
        $expectedJackValue = 12;
        $expectedQueenValue = 13;
        $expectedKingValue = 14;

        $jackCard = new Card(Card::JACK, Suit::club(false));
        $this->assertEquals($expectedJackValue, $jackCard->numericKey());

        $queenCard = new Card(Card::QUEEN, Suit::heart(false));
        $this->assertEquals($expectedQueenValue, $queenCard->numericKey());

        $kingCard = new Card(Card::KING, Suit::spade(false));
        $this->assertEquals($expectedKingValue, $kingCard->numericKey());
    }

    public function testReadableValueNameReturnsCorrectForFaceCards(){
        $jackCard = new Card(Card::JACK, Suit::club());
        $this->assertEquals("Jack", $jackCard->readableValueName());

        $queenCard = new Card(Card::QUEEN, Suit::club());
        $this->assertEquals("Queen", $queenCard->readableValueName());

        $kingCard = new Card(Card::KING, Suit::club());
        $this->assertEquals("King", $kingCard->readableValueName());

        $aceCard = new Card(Card::ACE, Suit::club());
        $this->assertEquals("Ace", $aceCard->readableValueName());


    }

}

