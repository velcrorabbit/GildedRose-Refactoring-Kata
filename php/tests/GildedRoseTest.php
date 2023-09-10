<?php

declare(strict_types=1);

namespace Tests;

use GildedRose\GildedRose;
use GildedRose\Item;
use PHPUnit\Framework\TestCase;

class GildedRoseTest extends TestCase
{
    public function testItemNameSetCorrectly(): void
    {
        $items = [new Item('foo', 0, 0)];
        $gildedRose = new GildedRose($items);
        $gildedRose->updateQuality();
        $this->assertSame('foo', $items[0]->name);
    }

    public function testQualityDegradesTwiceAfterSellIn(): void
    {
        $items = [new Item('Test', 0, 4)];
        $gildedRose = new GildedRose($items);
        $gildedRose->updateQuality();
        $this->assertSame(2, $items[0]->quality);
    }

    public function testQualityIsNeverNegative(): void
    {
        $items = [new Item('Conjured', 1, 1)];
        $gildedRose = new GildedRose($items);
        $gildedRose->updateQuality();
        $this->assertSame(0, $items[0]->quality);
    }

    public function testAgedBrieQualityIncreasesOverTime(): void
    {
        $items = [new Item('Aged Brie', 2, 2)];
        $gildedRose = new GildedRose($items);
        $gildedRose->updateQuality();
        $this->assertSame('Aged Brie', $items[0]->name);
        $this->assertSame(1, $items[0]->sellIn);
        $this->assertSame(3, $items[0]->quality);
    }

    public function testAgedBrieNeverExcedesFifty(): void
    {
        $items = [new Item('Aged Brie', 2, 50)];
        $gildedRose = new GildedRose($items);
        $gildedRose->updateQuality();
        $this->assertSame(50, $items[0]->quality);
    }

    public function testSulfurasStaysTheSame(): void
    {
        $items = [new Item('Sulfuras', 2, 80)];
        $gildedRose = new GildedRose($items);
        $gildedRose->updateQuality();
        $this->assertSame(80, $items[0]->quality);
        $this->assertSame(2, $items[0]->sellIn);
    }

    public function testTicketsQulalityIncreaseElevenDays(): void
    {
        $items = [new Item('Backstage passes', 11, 2)];
        $gildedRose = new GildedRose($items);
        $gildedRose->updateQuality();
        $this->assertSame(3, $items[0]->quality);
    }

    public function testTicketsQulalityIncreaseNineDays(): void
    {
        $items = [new Item('Backstage passes', 9, 2)];
        $gildedRose = new GildedRose($items);
        $gildedRose->updateQuality();
        $this->assertSame(4, $items[0]->quality);
    }

    public function testTicketsQulalityIncreasThreeDays(): void
    {
        $items = [new Item('Backstage passes', 3, 2)];
        $gildedRose = new GildedRose($items);
        $gildedRose->updateQuality();
        $this->assertSame(5, $items[0]->quality);
    }

    public function testTicketsQulalityZeroAfterSellIn(): void
    {
        $items = [new Item('Backstage passes', 0, 2)];
        $gildedRose = new GildedRose($items);
        $gildedRose->updateQuality();
        $this->assertSame(0, $items[0]->quality);
    }

    public function testConjuredDegradesDouble(): void
    {
        $items = [new Item('Conjured', 10, 10)];
        $gildedRose = new GildedRose($items);
        $gildedRose->updateQuality();
        $this->assertSame(8, $items[0]->quality);
    }
}
