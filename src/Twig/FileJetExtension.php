<?php

declare(strict_types=1);

namespace FileJetBundle\Twig;

use FileJet\File;
use FileJet\FileInterface;
use FileJet\FileJet;

class FileJetExtension extends \Twig_Extension
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
            new \Twig_SimpleFunction('file_url', [$this, 'getUrl']),
            new \Twig_SimpleFunction('private_file_url', [$this->fileJet, 'getPrivateUrl'])
        ];
    }

    public function getUrl(FileInterface $file, string $mutation = null): string
    {
        return $this->fileJet->getUrl(new File($file->getIdentifier(), $mutation ?? $file->getMutation(), $file->getCustomName()));
    }
}
