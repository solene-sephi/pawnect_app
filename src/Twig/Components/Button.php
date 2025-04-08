<?php

namespace App\Twig\Components;

use Symfony\UX\TwigComponent\Attribute\PreMount;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;
use Symfony\UX\TwigComponent\Attribute\ExposeInTemplate;

#[AsTwigComponent('Button')]
class Button
{
    public ?string $route;

    public string $type;

    public ?string $iconafter;

    public ?string $iconbefore;

    #[ExposeInTemplate]
    private string $tag = 'button';

    #[ExposeInTemplate]
    private string $btnClasses = '';

    #[ExposeInTemplate]
    private string $iconClasses = '';

    private string $size;

    private string $color;


    #[PreMount]
    public function preMount(array $data): array
    {
        $resolver = new OptionsResolver();
        $resolver->setIgnoreUndefined(true);

        $resolver->setDefaults([
            'type' => 'button',
            'color' => 'tertiary',
            'size' => 'regular',
            'route' => null,
            'isfullwidth' => false,
            'iconbefore' => null,
            'iconafter' => null,
        ]);

        $resolver->setAllowedTypes('color', 'string');
        $resolver->setAllowedTypes('size', 'string');
        $resolver->setAllowedTypes('isfullwidth', 'bool');
        $resolver->setAllowedTypes('iconbefore', ['null', 'string']);
        $resolver->setAllowedTypes('iconafter', ['null', 'string']);

        return $resolver->resolve($data) + $data;
    }

    public function mount(
        string $color,
        string $size,
        bool $isfullwidth
    ): void {
        $this->size = $size;
        $this->color = $color;
        $this->btnClasses = $this->buildButtonClasses($color, $size, $isfullwidth);
    }

    private function buildButtonClasses(string $color, string $size, bool $isfullwidth): string
    {

        return implode(' ', array_filter([
            $this->computeColorClass($color),
            $this->computeSizeClass($size),
            $isfullwidth ? 'w-full' : null,
        ]));
    }

    private function computeColorClass(string $color): string
    {
        return match ($color) {
            'primary' => 'text-primary-50 bg-primary-900 hover:bg-primary-800 focus:ring-primary-500',
            'secondary' => 'text-secondary-950 bg-secondary-400 hover:bg-secondary-300 focus:ring-secondary-400',
            'tertiary' => 'text-tertiary-950 bg-tertiary-200 hover:bg-tertiary-300 focus:ring-tertiary-400',
            'primary-outline' => 'text-primary-950 border border-primary-950 hover:bg-primary-50',
            default => throw new \LogicException(sprintf('Unknown button color "%s"', $color)),
        };
    }

    private function computeSizeClass(string $size): string
    {
        return match ($size) {
            'small' => 'text-sm px-3 py-1.5',
            'regular' => 'text-sm px-5 py-2.5',
            'large' => 'text-lg px-8 py-3',
            default => throw new \LogicException(sprintf('Unknown button size "%s"', $size)),
        };
    }

    private function computeIconSizeClass(string $size): string
    {
        return match ($size) {
            'small' => 'size-4',
            'regular' => 'size-5',
            'large' => 'size-6',
            default => throw new \LogicException(sprintf('Unknown button size "%s"', $size)),
        };
    }

    public function getTag(): string
    {
        return $this->route ? 'a' : 'button';
    }

    public function getIconClasses(): string
    {
        return $this->hasIcon() ? $this->computeIconSizeClass($this->size) : '';
    }

    public function getBtnClasses(): string
    {
        return $this->hasIcon()
            ? "{$this->btnClasses} flex items-center justify-center gap-2"
            : $this->btnClasses;
    }

    private function hasIcon(): bool
    {
        return $this->iconafter !== null || $this->iconbefore !== null;
    }

    private function joinClasses(array $classes): string
    {
        return implode(' ', array_filter($classes));
    }
}