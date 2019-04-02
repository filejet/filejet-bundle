<?php

declare(strict_types=1);

namespace FileJetBundle\Twig;

use FileJet\Config;
use FileJet\File;
use FileJet\FileInterface;
use FileJet\FileJet;

class FileJetExtension extends \Twig_Extension
{
    /** @var FileJet */
    private $fileJet;
    /** @var Config */
    private $config;

    public function __construct(FileJet $fileJet, Config $config)
    {
        $this->fileJet = $fileJet;
        $this->config = $config;
    }

    public function getFunctions()
    {
        return [
            new \Twig_SimpleFunction('file_url', [$this, 'getUrl']),
            new \Twig_SimpleFunction('asset_url', [$this, 'getAsset']),
            new \Twig_SimpleFunction('external_file_url', [$this->fileJet, 'getExternalUrl']),
            new \Twig_SimpleFunction('private_file_url', [$this->fileJet, 'getPrivateUrl'])
        ];
    }

    public function getUrl(FileInterface $file, string $mutation = null): string
    {
        return $this->fileJet->getUrl(new File($file->getIdentifier(), $mutation ?? $file->getMutation()));
    }

    public function getAsset(string $path, string $mutation = null): string
    {
        $mutation = empty($mutation) ? '' : "/${mutation}";
        $originPath = urlencode("{$this->config->getBaseUrl()}{$path}");

        return "{$this->config->getPublicUrl()}/ext{$mutation}?src={$originPath}";
    }
}
