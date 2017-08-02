<?php

namespace App\Services\Uploaders;

use Intervention\Image\ImageManagerStatic as Image;

abstract class ImageUploader extends Uploader 
{
	
	/**
	 * Default image extensions
	 * 
	 * @var array
	 */
	protected $allowedExtensions = ['png', 'jpg', 'jpeg'];
	
	/**
	 * Allowed images sizes Ex. [[width, height], [width, height]] or false
	 *
	 * @var array
	 */
	protected $allowedSizes = false;
	
	/**
	 * @var \Intervention\Image\Image
	 */
	protected $image;
	
	/**
	 * Informa se deve ou não gerar um thumbnail
	 * 
	 * @var boolean
	 */
	protected $thumbnaill = false;
	
	/**
	 * Size of thumbnail
	 *
	 * @var boolean
	 */
	protected $thumbnailSize = 200;
	
	/**
	 * Método responsável por pegar o contents e a extensão do arquivo
	 */
	protected function parse() 
	{
		$this->extension = last(explode('/', $this->image->mime()));
		$this->contents  = (string) $this->image->encode(); // encode it as string;
	}
	
	/**
	 * Faz o upload do arquivo.
	 *
	 * @param mixed string|null $filename
	 *
	 * @return string $filename
	 */
	public function upload($file, $filename = null) 
	{
		$this->image = Image::make($file);
		$this->parse();
		$this->validateFileExtension();
		$this->validateImageSizes();
	
		if ($filename)
			$filename = $filename . '.' . $this->extension;
		else
			$filename = $file->getClientOriginalName();
	
		$this->disk->put(
			"{$this->path}/{$filename}",
			$this->contents,
			$this->visibility
		);
		
		if ($this->thumbnaill) {
			$this->generateThumbnail($filename);
		}
	
		return $filename;
	}
	
	/**
	 * Remove uma imagem.
	 *
	 * @param string $filename
	 *
	 * @return string $filename
	 */
	public function delete($filename) 
	{
		if ($this->thumbnaill) {
			 parent::delete("thumb-{$filename}");
		}
	
		return parent::delete($filename);
	}
	
	/**
	 * Gera o thumbnail da imagem
	 */
	public function generateThumbnail(string $filename) 
	{
		$this->image->resize($this->thumbnailSize, null, function ($constraint) {
		    $constraint->aspectRatio();
		});
		
		$this->image->encode('png');
		$payload = (string) $this->image->encode();
		
		$this->disk->put(
			"{$this->path}/thumb-{$filename}",
			$payload,
			$this->visibility
		);
	}
	
	/**
	 * Validate image size
	 * 
	 * @return boolean
	 */
	private function validateImageSizes() 
	{
		if (!$this->allowedSizes) {
			return true;
		}
		
		foreach ($this->allowedSizes as $size) {
			if ($this->image->width() == $size[0] && $this->image->height() == $size[1]) {
				return true;
			}
		}
		
		throw new \Exception(
			"Image size {$this->image->width()}x{$this->image->height()} was not allowed."
		);
	}
}