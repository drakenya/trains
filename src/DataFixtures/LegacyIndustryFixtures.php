<?php
/**
 * Created by PhpStorm.
 * User: Andrew Kroll <andrew.kroll@bhnetwork.com>
 * Date: 4/10/18
 * Time: 10:45 AM
 */

namespace App\DataFixtures;

use App\LegacyIndustry\Creator;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpKernel\KernelInterface;

class LegacyIndustryFixtures extends Fixture
{
    private const FILES = [
        'opsig/OpSigEST.txt' => 'OpSig / EST',
        'opsig/OpSigMWC.txt' => 'OpSig / MWC',
        'opsig/OpSigSTH.txt' => 'OpSig / STH',
        'opsig/OpSigWST.txt' => 'OpSig / WST',
        'opsig/OpSigWEST.txt' => 'OpSig / West',
        'opsig/OpSigCANADA.txt' => 'OpSig / Canada',
        'keystone_crossings/OpSig_baltimoreeastern1945_170906.txt' => 'Keystone Crossings / Baltimore & Eastern R. R.',
        'keystone_crossings/OpSig_cnj1945_170906.txt' => 'Keystone Crossings / Central Railroad of New Jersey',
        'keystone_crossings/OpSig_hbtm1942_170802.txt' => 'Keystone Crossings / Huntingdon & Broad Top Mountain Railroad',
        'keystone_crossings/OpSig_nylb1945_170906.txt' => 'Keystone Crossings / New York & Long Branch R. R.',
        'keystone_crossings/OpSig_prratlantic1945_171120.txt' => 'Keystone Crossings / Pennsylvania Railroad Atlantic Division',
        'keystone_crossings/OpSig_prrdelmarva1945_171004.txt' => 'Keystone Crossings / Pennsylvania Railroad Delmarva Division',
        'keystone_crossings/OpSig_prrmaryland1945_170906.txt' => 'Keystone Crossings / Pennsylvania Railroad Maryland Division',
        'keystone_crossings/OpSig_prrmiddle1945_170802.txt' => 'Keystone Crossings / Pennsylvania Railroad Middle Division',
        'keystone_crossings/OpSig_prrnewyork1945_171004.txt' => 'Keystone Crossings / Pennsylvania Railroad New York Division',
        'keystone_crossings/OpSig_prrphiladelphia1945_170807.txt' => 'Keystone Crossings / Pennsylvania Railroad Philadelphia Division',
        'keystone_crossings/OpSig_prrphilaterm1945_171116.txt' => 'Keystone Crossings / Pennsylvania Railroad Philadelphia Terminal Division',
        'keystone_crossings/OpSig_prrpittsburgh1945_170807.txt' => 'Keystone Crossings / Pennsylvania Railroad Pittsburgh Division',
        'keystone_crossings/OpSig_prrwilkesbarre1945_170807.txt' => 'Keystone Crossings / Pennsylvania Railroad Wilkes-Barre Division',
        'keystone_crossings/OpSig_prrwilliamsport1945_170807.txt' => 'Keystone Crossings / Pennsylvania Railroad Williamsport Division',
    ];

    private $kernel;
    private $creator;

    public function __construct(KernelInterface $kernel, Creator $creator)
    {
        $this->kernel = $kernel;
        $this->creator = $creator;
    }

    public function load(ObjectManager $manager)
    {
        ini_set("auto_detect_line_endings", true);

        foreach (static::FILES as $fileName => $fileSource) {
            $file = sprintf('%s/../var/data/%s', $this->kernel->getRootDir(), $fileName);

            if (!file_exists($file)) {
                continue;
            }

            $filePointer = fopen($file, 'r');
            while (($data = fgetcsv($filePointer, 0, "\t")) !== false) {
                $record = $this->creator->create($data)
                    ->setExternalSource($fileSource)
                ;

                $manager->persist($record);
            }

            $manager->flush();
        }
    }
}