<?php

declare(strict_types=1);

namespace Zentlix\MainBundle\UI\Http\Web\Twig\Extension\Admin;

use Twig\Environment;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;
use Zentlix\MainBundle\Domain\Attribute\Repository\AttributeRepository;
use Zentlix\MainBundle\Domain\Attribute\Service\AttributeTypes;

final class AttributesExtension extends AbstractExtension
{
    private AttributeTypes $types;
    private AttributeRepository $repository;

    public function __construct(AttributeTypes $types, AttributeRepository $repository)
    {
        $this->types = $types;
        $this->repository = $repository;
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction(
                'admin_attribute_types',
                fn (Environment $twig, string $entity = null) =>
                    $twig->render('@MainBundle/admin/widgets/attributes/types.html.twig', [
                        'types' => $this->types->getTypes(),
                        'entity' => $entity,
                    ]),
                ['needs_environment' => true, 'is_safe' => ['html']]
            ),

            new TwigFunction(
                'admin_attributes_widget',
                fn (Environment $twig, string $entity) =>
                    $twig->render('@MainBundle/admin/widgets/attributes/attributes.html.twig', [
                        'attributes' => $this->repository->findEditableByEntity($entity),
                        'types' => $this->types,
                ]),
                ['needs_environment' => true, 'is_safe' => ['html']]
            ),
        ];
    }
}
