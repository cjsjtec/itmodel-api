<?php

namespace App\Services\Uploaders;

use Illuminate\Support\Facades\Storage;
use Illuminate\Contracts\Filesystem\Filesystem;

abstract class Uploader 
{
	
	/**
	 * @var array
	 */
	protected $allowedExtensions = [];
	
	/**
	 * @var Filesystem
	 */
	protected $disk;
	
	/**
	 * @var string
	 */
	protected $diskEnv = 's3';
	
	/**
	 * @var string
	 */
	protected $visibility = Filesystem::VISIBILITY_PUBLIC;
	
	/**
	 * @var mixed
	 */
	protected $file;
	
	/**
	 * @var string
	 */
	protected $extension;
	
	/**
	 * @var string
	 */
	protected $path;
	
	/**
	 * @var mixed
	 */
	protected $contents;
	
	public function __construct() 
	{
		$this->disk = Storage::disk($this->diskEnv);
		
		// O uso das extensoes permitidas é obrigatório por
		// questões de segurança.
		if (count($this->allowedExtensions) == 0) {
			throw new \Exception('Erro ao verificar extensões permitidas para o arquivo');	
		}
	}
	
	/**
	 * Método responsável por pegar o contents e a extensão do arquivo
	 */
	protected function parse() 
	{
		$this->extension = $this->file->getClientOriginalExtension();
		$this->contents  = file_get_contents($this->file);
	}
	
	
	/**
	 * Valida se a extensão é permitida para o download
	 * 
	 * @throws \Exception
	 * 
	 * @return boolean
	 */
	protected function validateFileExtension() 
	{
		if (!in_array($this->extension, $this->allowedExtensions)) {
			throw new \Exception("Extensão '{$this->extension}'  não permitida para o arquivo.");
		}
		
		return true;
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
		$this->file = $file;
		$this->parse();
		$this->validateFileExtension();
		
		if ($filename)
			$filename = $filename . '.' . $this->extension;
		else
			$filename = $this->file->getClientOriginalName();
		
		$this->disk->put(
			"{$this->path}/{$filename}",
			$this->contents,
			$this->visibility
		);
		
		return $filename;
	}
	
	/**
	 * Faz o update de um arquivo.
	 *
	 * @param mixed string|null $filename
	 *
	 * @return string $filename
	 */
	public function download($filename) 
	{
		if (!$this->exists($filename)) {
			throw new \Exception('Arquivo não encontrado.');
		}
		
		return $this->disk->get("{$this->path}/{$filename}");
	}
	
	/**
	 * Faz o update de um arquivo.
	 *
	 * @param mixed string|null $filename
	 *
	 * @return string $filename
	 */
	public function update($filename, $file, $newFilename = null) 
	{
		if (!$this->exists($filename)) {
			throw new \Exception('Arquivo não encontrado.');
		}
		
		$this->disk->move("{$this->path}/{$filename}", "{$this->path}/temp/{$filename}");
		
		try {
			
			// Remove a extensão do nome do arquivo
			if (!$newFilename) {
				$newFilename = explode('.', $filename);
				unset($newFilename[(count($newFilename) - 1)]);
				$newFilename = implode('.', $newFilename);
			}
			
			$newFilename = $this->upload($file, $newFilename);
			
			//Remove o arquivo temporário
			$this->disk->delete("{$this->path}/temp/{$filename}");
		} catch(\Exception $e) {
			$this->disk->move("{$this->path}/temp/{$filename}", "{$this->path}/{$filename}");
			throw new \Exception($e);
		}
	
		return $newFilename;
	}
	
	/**
	 * Faz o update de um arquivo.
	 *
	 * @param mixed string|null $filename
	 *
	 * @return string $filename
	 */
	public function updateOrCreate($filename, $file, $newFilename = null) 
	{
		if (!$filename || !$this->exists($filename)) {
			return $this->upload($file, ($newFilename ?: $filename));
		}
		
		return $this->update($filename, $file, $newFilename);
	}
	
	/**
	 * Remove um arquivo.
	 *
	 * @param mixed string|null $filename
	 *
	 * @return string $filename
	 */
	public function delete($filename) 
	{
		if (!$this->exists($filename)) {
			return true;
		}
	
		$this->disk->delete("{$this->path}/{$filename}");
	}
	
	/**
	 * Verifica se o arquivo existe
	 *
	 * @param mixed string|null $filename
	 *
	 * @return boolean
	 */
	public function exists($filename) 
	{
		return $this->disk->exists("{$this->path}/{$filename}");
	}
}