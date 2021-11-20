<?php

declare(strict_types=1);

namespace Zentlix\MainBundle\UI\Http\Web\Controller;

use Symfony\Component\HttpFoundation\Response;

class IndexController extends AbstractSiteController
{
    public function index(): Response
    {
        return $this->render('index.html.twig', [
            'meta_title' => $this->site->getMetaTitle(),
            'meta_description' => $this->site->getMetaDescription(),
            'meta_keywords' => $this->site->getMetaKeywords()
        ]);
    }
}
