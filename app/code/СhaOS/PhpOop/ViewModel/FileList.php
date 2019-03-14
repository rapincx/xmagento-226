<?php

namespace ChaOS\PhpOop\ViewModel;

class FileList implements \Magento\Framework\View\Element\Block\ArgumentInterface
{
    /**
     * @var \Magento\Framework\Filesystem\DirectoryList
     */
    protected $_dir;
    private $recursiveIteratorConst = \RecursiveIteratorIterator::CHILD_FIRST;
    const RECURSIVE_ITERATOR = \RecursiveIteratorIterator::CHILD_FIRST;

    /**
     * FilesList constructor.
     * @param \Magento\Framework\Filesystem\DirectoryList $dir
     */
    public function __construct(
        \Magento\Framework\Filesystem\DirectoryList $dir
    )
    {
        $this->_dir = $dir;
    }

    /**
     * @param $startDirPath
     * @return \RecursiveIteratorIterator
     */

    private function getRecursiveIterator($startDirPath): \RecursiveIteratorIterator
    {
        return new \RecursiveIteratorIterator(
            new \RecursiveDirectoryIterator($this->buildPath($startDirPath)),
            $this->recursiveIteratorConst
        );
    }

    /**
     * @param $startDirPath
     * @return array
     */
    public function getFileList($startDirPath): array
    {
        $fileList = [];
        $recursiveIterator = $this->getRecursiveIterator($startDirPath);
        foreach ($recursiveIterator as $fileItem) {
            if ($fileItem->getFilename() === '.' || $fileItem->getFilename() === '..') {
                continue;
            }
            $fileList[$fileItem->getFilename()] = [
                'path' => $fileItem->getPathname(),
                'created/modified' => $fileItem->getFilename(),
            ];
        }
        return $fileList;
    }

    /**
     * @param $startDirPath
     * @return string
     */
    protected function buildPath($startDirPath): string
    {
        return $this->_dir->getRoot() . '/' . $startDirPath;
    }
}