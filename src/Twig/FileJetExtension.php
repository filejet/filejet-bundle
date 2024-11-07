<?php

declare(strict_types=1);

namespace FileJetBundle\Twig;

use FileJet\Config;
use FileJet\File;
use FileJet\FileInterface;
use FileJet\FileJet;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class FileJetExtension extends AbstractExtension
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
            new TwigFunction('file_url', [$this, 'getUrl']),
            new TwigFunction('asset_url', [$this, 'getAsset']),
            new TwigFunction('external_file_url', [$this->fileJet, 'getExternalUrl']),
            new TwigFunction('private_file_url', [$this->fileJet, 'getPrivateUrl'])
        ];
    }

    public function getUrl(FileInterface $file, string $mutation = null): string
    {
        return $this->fileJet->getUrl(new File($file->getIdentifier(), $mutation ?? $file->getMutation()));
    }

    public function getAsset(string $path, string $mutation = null): string
    {
        $mutation = empty($mutation) ? '' : "/${mutation}";
        $mutation .= $this->config->isAutoMode() ? ',auto' : '';
        $originPath = urlencode("{$this->config->getBaseUrl()}{$path}");

        return "{$this->config->getPublicUrl()}/ext{$mutation}?src={$originPath}";
    }
}
