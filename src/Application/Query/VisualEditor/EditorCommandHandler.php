<?php

declare(strict_types=1);

namespace Zentlix\MainBundle\Application\Query\VisualEditor;

use Doctrine\ORM\EntityManagerInterface;
use Zentlix\MainBundle\Infrastructure\Share\Bus\QueryHandlerInterface;
use Zentlix\MainBundle\Infrastructure\Share\Bus\VisualEditorCommandInterface;

class EditorCommandHandler implements QueryHandlerInterface
{
    public function __construct(
        private EntityManagerInterface $entityManager
    ) {
    }

    public function __invoke(EditorCommandQuery $query): VisualEditorCommandInterface
    {
        if (!class_exists($query->getClass())) {
            throw new \Exception(sprintf('Класс %s не найден.', $query->getClass()));
        }

        $repository = $this->entityManager->getRepository($query->getClass());

        /** @var $entity */
        $entity = $repository->findOneBy(['code' => $query->getCode()]);

        if (!$entity) {
            throw new \Exception(sprintf('Entity с символьным кодом %s не найдена.', $query->getCode()));
        }

        $reflection = new \ReflectionClass($query->getClass());
        $parameters = $reflection->getMethod('update')->getParameters();

        if (!isset($parameters[0]) || null === $parameters[0]->getType()) {
            throw new \Exception(
                sprintf('Метод edit класса %s должен содержать первым параметром класс, 
                имплементирующий интерфейс VisualEditorCommandInterface.', $query->getClass())
            );
        }

        $commandClass = $parameters[0]->getType()->getName();
        $command = new $commandClass($entity);

        if (!$command instanceof VisualEditorCommandInterface) {
            throw new \Exception(
                sprintf('Класс %s должен имплементировать интерфейс VisualEditorCommandInterface.', $commandClass)
            );
        }

        return $command;
    }
}
