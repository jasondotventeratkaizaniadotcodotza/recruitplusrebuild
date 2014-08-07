<?php

namespace RM\Console\Command;

use Symfony\Component\Console\Input\InputArgument,
    Symfony\Component\Console\Input\InputOption,
    Symfony\Component\Console;

class ImportGeolocationsCommand extends Console\Command\Command
{

    protected $linkToGeonamesZipsFolder = 'http://download.geonames.org/export/zip/';
    protected $pathToGeolocations = '/../data/downloads/geolocations/';
    protected $zaZip = 'ZA.zip';
    protected $reameTxt = 'readme.txt';
    protected $zaTxt = 'ZA.txt';

    /**
     * @see Console\Command\Command
     */
    protected function configure()
    {
        $this->setName('rm:import-geolocations')
             ->setDescription('Import ZA postal codes from http://download.geonames.org/export/zip/ZA.zip')
             ->setHelp(<<<EOT
Imports ZA postal code information
EOT
        );
    }

    /**
     * @see Console\Command\Command
     */
    protected function execute(Console\Input\InputInterface $input, Console\Output\OutputInterface $output)
    {
        $em = $this->getHelper('em')->getEntityManager();
        $errorMessage = null;
        try {
            $output->write('Downloading file...' . PHP_EOL);
            $file = $this->linkToGeonamesZipsFolder . $this->zaZip;
            $newfile = APPLICATION_PATH . $this->pathToGeolocations . $this->zaZip;

            if (!copy($file, $newfile)) {
                $output->write('Failed to copy ' . $file . '...' . PHP_EOL);
            }

            $status = true;
            $zip = new \ZipArchive;
            $res = $zip->open($newfile, \ZipArchive::CREATE);
            if ($res === TRUE) {
                $output->write('Extracting file...' . PHP_EOL);
                $zip->extractTo(APPLICATION_PATH . $this->pathToGeolocations);
                $zip->close();
            } else {
                $status = false;
            }
            if ($status === true) {
                $filePath = APPLICATION_PATH . $this->pathToGeolocations . $this->zaTxt;
                $fileRows = file($filePath);

                $geolocationService = new \RM\Entity\GeolocationService($em);

                $output->write('Inserting rows...' . PHP_EOL);
                foreach ($fileRows as $key => $row) {
                    $rowArray = explode("\t", $row);
                    $entity = $geolocationService->getNewGeolocationEntity();
                    if ($key == 0) {
                        $firstRow = $geolocationService->getNewGeolocationEntity();
                        $rowArray[\RM\Entity\GeolocationService::ID_KEY] = null;
                        $firstRow = $geolocationService->initNoLocationRow($firstRow, $rowArray);
                        $em->persist($firstRow);
                        $em->flush();
                    }
                    $rowArray[\RM\Entity\GeolocationService::ID_KEY] = $key + 2;
                    $entity = $geolocationService->createEntityFromFileRow($entity, $rowArray);
                    $em->persist($entity);
                }
                $em->flush();
                
                unlink(APPLICATION_PATH . $this->pathToGeolocations . $this->zaTxt);
                unlink($newfile);
                unlink(APPLICATION_PATH . $this->pathToGeolocations . $this->reameTxt);
            }
        } catch (Exception $e) {
            $errorMessage = $e->getMessage();
            RM_Logger::info($e->getMessage());
        }
        if ($errorMessage) {
            $output->write($errorMessage . PHP_EOL);
        } else {
            $output->write('Table information was imported successfully' . PHP_EOL);
        }
    }

}
