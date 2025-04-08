<?php

namespace App\Twig\Components;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;
use Symfony\UX\TwigComponent\Attribute\ExposeInTemplate;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\UX\TwigComponent\Attribute\PreMount;

#[AsTwigComponent('Alert')]
final class Alert
{
    public string $message;

    public string $type;

    public string $label;

    #[ExposeInTemplate]
    private string $blockClasses;

    #[ExposeInTemplate]
    private string $closeButtonClasses;

    #[ExposeInTemplate]
    private string $id;

    #[ExposeInTemplate]
    private bool $closable;

    // PreMount: Validation et normalisation des données
    #[PreMount]
    public function preMount(array $data): array
    {
        $resolver = new OptionsResolver();
        $resolver->setIgnoreUndefined(true);

        $resolver->setDefaults([
            'type' => 'info',
            'closable' => false,
            'id' => null,
            'context' => null,
        ]);

        $resolver->setAllowedTypes('closable', 'bool');

        // If the alert is closable, an ID is required to allow JavaScript to properly handle the close action.
        // If the ID is not explicitly passed, we require a 'context' parameter to generate a unique ID for the alert.
        // The context provides a fallback to generate an ID when it's not provided directly.
        if ($data['closable'] && !isset($data['id'])) {
            $resolver->setRequired('context');
            $resolver->setAllowedTypes('context', 'string');
        }

        return $resolver->resolve($data) + $data;
    }

    // Mount: Logique de construction des données pour le rendu
    public function mount(string $type, bool $closable, ?string $context, ?string $id): void
    {
        $this->blockClasses = $this->buildBlockClasses($type);
        $this->closeButtonClasses = $this->buildCloseButtonClasses($type);

        $this->id = $id ?? "{$type}-{$context}";

        $this->closable = $closable;
    }

    private function buildBlockClasses(string $type): string
    {
        $default = 'bg-blue-50 text-blue-700 border-blue-700';

        return match ($type) {
            'success' => 'bg-green-50 text-green-700 border-green-700',
            'error' => 'bg-red-50 text-red-700 border-red-700',
            'warning' => 'bg-orange-50 text-orange-700 border-orange-700',
            'info' => $default,
            default => $default,
        };
    }

    private function buildCloseButtonClasses(string $type): string
    {
        $default = 'bg-blue-50 text-blue-500 hover:bg-blue-200 focus:ring-blue-400';

        return match ($type) {
            'success' => 'bg-green-50 text-green-500 hover:bg-green-200 focus:ring-green-400',
            'error' => 'bg-red-50 text-red-500 hover:bg-red-200 focus:ring-red-400',
            'warning' => 'bg-orange-50 text-orange-500 hover:bg-orange-200 focus:ring-orange-400',
            'info' => $default,
            default => $default,
        };
    }

    public function getBlockClasses(): string
    {
        return $this->blockClasses;
    }

    public function getCloseButtonClasses(): string
    {
        return $this->closeButtonClasses;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getClosable(): bool
    {
        return $this->closable;
    }

}
