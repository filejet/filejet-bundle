<?php

declare(strict_types=1);

namespace FileJetBundle\Twig;

use FileJet\FileJet;

class UrlProviderExtension extends \Twig_Extension
{
    /** @var FileJet */
    private $fileJet;

    public function __construct(FileJet $fileJet)
    {
        $this->fileJet = $fileJet;
    }

    public function getFunctions()
    {
        return [
            new \Twig_SimpleFunction(
                'file_url', [$this->fileJet, 'getUrl']
            ),
            new \Twig_SimpleFunction(
                'private_file_url', [$this->fileJet, 'getPrivateUrl']
            )
        ];
    }
}
