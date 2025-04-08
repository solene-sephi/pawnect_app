<?php

namespace App\Twig\Components;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent('Dropdown')]
final class Dropdown
{
    public string $id;
    public string $icon;
    public string $label;
    public array $subitems;
}
