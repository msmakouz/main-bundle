<?php

declare(strict_types=1);

namespace Zentlix\MainBundle\Domain\Site\Service;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Zentlix\MainBundle\Domain\Site\Entity\Site;
use Zentlix\MainBundle\Domain\Cache\Service\Cache;

class Sites
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private RequestStack $request
    ) {
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
        $host = $this->getHost();

        if(\is_null($host)) {
            throw new \DomainException('Host is null.');
        }

        if(!isset($this->getSites()[$host])) {
            throw new \DomainException('Site for current URL not found.');
        }

        return $this->getSites()[$host];
    }

    public function getCurrentSiteId(): string
    {
        return $this->getCurrentSite()->getId()->toRfc4122();
    }

    public function hasCurrentSite(): bool
    {
        $host = $this->getHost();

        return \is_null($host) === false && isset($this->getSites()[$host]);
    }

    public static function clearCache(): void
    {
        Cache::clear(Cache::SITES);
    }

    private function getHost(): ?string
    {
        if($this->request->getCurrentRequest()) {
            return $this->request->getCurrentRequest()->server->get('SERVER_NAME');
        }

        return null;
    }
}
