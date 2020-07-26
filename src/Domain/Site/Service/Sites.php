<?php

/**
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Zentlix to newer
 * versions in the future. If you wish to customize Zentlix for your
 * needs please refer to https://docs.zentlix.io for more information.
 */

declare(strict_types=1);

namespace Zentlix\MainBundle\Domain\Site\Service;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Zentlix\MainBundle\Domain\Site\Entity\Site;
use Zentlix\MainBundle\Domain\Cache\Service\Cache;

class Sites {

    private ContainerInterface $container;
    private ?EntityManagerInterface $entityManager;
    private ?string $host = null;

    public function __construct(ContainerInterface $container, RequestStack $request)
    {
        $this->container = $container;
        $this->entityManager = $container->get('doctrine.orm.entity_manager');

        if($request->getCurrentRequest()) {
            $this->host = $request->getCurrentRequest()->server->get('SERVER_NAME');
        }
    }

    public function getSites()
    {
        if(Cache::get(Cache::SITES)) {
            return Cache::get(Cache::SITES);
        }

        $repository = $this->entityManager->getRepository(Site::class);

        $cache = [];
        /** @var Site $site */
        foreach ($repository->findAllWithTemplates() as $site) {
            $cache[$site->getUrl()] = $site;
        }

        Cache::set($cache, Cache::SITES);

        return $cache;
    }

    public function getCurrentSite(): Site
    {
        if(is_null($this->host)) {
            throw new \DomainException('Host is null.');
        }

        if(!isset($this->getSites()[$this->host])) {
            throw new \DomainException('Site for current URL not found.');
        }

        return $this->getSites()[$this->host];
    }

    public function getCurrentSiteId(): int
    {
        return $this->getCurrentSite()->getId();
    }

    public static function clearCache(): void
    {
        Cache::clear(Cache::SITES);
    }
}