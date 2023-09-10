<?php

declare(strict_types=1);

namespace GildedRose;

final class GildedRose
{
    /**
     * @param Item[] $items
     */
    public function __construct(
        private array $items
    ) {
    }

    // Working strictly with improving existing code
    public function updateQuality(): void
    {
        foreach ($this->items as $item) {
            if ($item->quality < 50 && $item->quality > 0) {
                switch ($item->name) {
                    case str_contains($item->name, 'Aged Brie'):
                        $item->quality += 1;
                        break;
                    case str_contains($item->name, 'Backstage passes'):
                        if ($item->sellIn > 10) {
                            $item->quality += 1;
                        } elseif ($item->sellIn > 5) {
                            $item->quality += 2;
                        } elseif ($item->sellIn > 0) {
                            $item->quality += 3;
                        } else {
                            $item->quality = 0;
                        }
                        break;
                    case str_contains($item->name, 'Sulfuras'):
                        break;
                    case str_contains($item->name, 'Conjured'):
                        $item->quality -= 2;
                        break;
                    default:
                        if ($item->sellIn > 0) {
                            $item->quality -= 1;
                        } else {
                            $item->quality -= 2;
                        }
                        break;
                }
                $item->quality = ($item->quality < 0) ? 0 : $item->quality;
            }
            if (!str_contains($item->name, 'Sulfuras')) {
                $item->sellIn = $item->sellIn - 1;
            }
        }
    }   
}
