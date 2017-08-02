<?php

namespace App\Services\Uploaders\Products;

use App\Services\Uploaders\ImageUploader;

class ImageProduct extends ImageUploader 
{
	/**
	 * @var string
	 */
	protected $path = '';
	
	/**
	 * Default image extensions
	 *
	 * @var array
	 */
	protected $allowedExtensions = ['png', 'jpg', 'jpeg'];
		
	/**
	 * Informa se deve ou não gerar um thumbnail
	 *
	 * @var boolean
	 */
	protected $thumbnaill = true;
	
}