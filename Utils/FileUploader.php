<?php
/**
 * Created by Kévin Hilairet <kevin@octopouce.mu>
 * Date: 22/03/2018
 */

namespace Octopouce\AdvertisingBundle\Utils;

use Symfony\Component\HttpFoundation\File\UploadedFile;

class FileUploader {

	private $targetDirectory;

	public function __construct(string $targetDirectory)
	{
		$this->targetDirectory = $targetDirectory;
	}

	public function upload(UploadedFile $file, $path = null)
	{

		$file->move(str_replace('//', '/', $this->getTargetDirectory().'/'.$path), $file->getClientOriginalName());
		return $file->getClientOriginalName();
	}

	public function getTargetDirectory()
	{
		return $this->targetDirectory;
	}
}