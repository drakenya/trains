<?php
/**
 * Created by PhpStorm.
 * User: Andrew Kroll <andrew.kroll@bhnetwork.com>
 * Date: 5/1/18
 * Time: 2:21 PM
 */

namespace App\LegacyIndustry\Loader;


use App\LegacyIndustry\Creator;
use Doctrine\ORM\EntityManagerInterface;

class Loader
{
    private $manager;
    private $creator;
    private $directory;
    private $files = [];

    public function __construct(
        EntityManagerInterface $manager,
        Creator $creator,
        string $directory,
        array $files
    )
    {
        $this->manager = $manager;
        $this->creator = $creator;
        $this->directory = $directory;
        $this->files = $files;
    }

    public function load()
    {
        $lineEndingSetting = ini_get('auto_detect_line_endings');
        ini_set('auto_detect_line_endings', true);

        foreach ($this->files as $importFile) {
            [$fileName, $fileSource] = $importFile;
            $file = sprintf('%s/%s', $this->directory, $fileName);

            if (!file_exists($file)) {
                continue;
            }

            $filePointer = fopen($file, 'r');
            while (($data = fgetcsv($filePointer, 0, "\t")) !== false) {
                $record = $this->creator->create($data)
                    ->setExternalSource($fileSource)
                ;

                $this->manager->persist($record);
            }

            $this->manager->flush();
        }

        ini_set('auto_detect_line_endings', $lineEndingSetting);
    }
}