<?php

namespace AppBundle\Service;

use RobbieP\ZbarQrdecoder\ZbarDecoder;
use RecursiveIteratorIterator;
use RecursiveDirectoryIterator;

class PDFService
{
    /**
     * @var ZbarDecoder
     */
    protected $decoder;

    /**
     * @var string
     */
    protected $pdfsPath;

    /**
     * @var array
     */
    protected $acceptedTypes = array(
        "application/pdf"
    );

    public function __construct()
    {
        $this->decoder = new ZbarDecoder();
        $this->pdfsPath = realpath(__DIR__ . '/../../../web/pdfs/');
    }

    /**
     * @return array
     */
    public function getEstablishedPDFCodes()
    {
        // Array for return data
        $returnData = [];

        // Hold the current item
        $thisData = null;

        // Loop through the directory and grab all pdf files.
        foreach (new RecursiveIteratorIterator(new RecursiveDirectoryIterator($this->pdfsPath)) as $file) {

            if ($file->isDir()) continue;

            $returnData[] = $this->buildFileData($file);
        }

        return $returnData;
    }

    protected function validate($fileType)
    {
        $extensions = [];
        $thisType= null;

        foreach ($this->acceptedTypes as $type) {
            $thisType = explode("/", $type);
            $extensions[] = $thisType[1];
        }

        if (!in_array($fileType, $this->acceptedTypes) && !in_array($fileType, $extensions)) {
            return "Only pdf files are allowed. " . $fileType . " detected.";
        }

        return false;
    }

    /**
     * @param $filesObject object
     * @return array
     */
    public function scanUploads($filesObject)
    {
        $data = [];

        foreach($filesObject as $file) {
            $data[] = $this->buildFileData($file, true);
        }

        return $data;
    }

    /**
     * @param $filePath string
     * @return mixed
     */
    protected function scanFile($filePath)
    {
        return $this->decoder->make($filePath);
    }

    protected function buildFileData($file, $uploaded = false)
    {
        $thisData = array();

        if ($uploaded) {
            $thisData = array(
                'name' => $file->getClientOriginalName(),
                'error' => $this->validate($file->getMimeType())
            );

            $thisData['message'] = $thisData['error']
                ? false
                : $this->scanFile($file);
        } else {
            $thisData = array(
                'name' => $file->getFilename(),
                'error' => $this->validate($file->getExtension())
            );

            $thisData['message'] = $thisData['error']
                ? false
                : $this->scanFile($file->getRealPath());
        }

        return $thisData;
    }
}