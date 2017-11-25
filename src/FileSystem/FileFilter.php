<?php declare(strict_types=1);

namespace Symplify\EasyCodingStandard\FileSystem;

use SplFileInfo;
use Symplify\EasyCodingStandard\ChangedFilesDetector\ChangedFilesDetector;
use Symplify\EasyCodingStandard\Skipper;

final class FileFilter
{
    /**
     * @var ChangedFilesDetector
     */
    private $changedFilesDetector;

    /**
     * @var Skipper
     */
    private $skipper;

    public function __construct(ChangedFilesDetector $changedFilesDetector, Skipper $skipper)
    {
        $this->changedFilesDetector = $changedFilesDetector;
        $this->skipper = $skipper;
    }

    /**
     * @param SplFileInfo[] $fileInfos
     * @return SplFileInfo[]
     */
    public function filterOnlyChangedFiles(array $fileInfos): array
    {
        $changedFiles = [];

        foreach ($fileInfos as $relativePath => $fileInfo) {
            if ($this->changedFilesDetector->hasFileChanged($relativePath)) {
                $changedFiles[] = $fileInfo;

                $this->changedFilesDetector->addFile($relativePath);
            } else {
                $this->skipper->removeFileFromUnused($relativePath);
            }
        }

        return $changedFiles;
    }
}
