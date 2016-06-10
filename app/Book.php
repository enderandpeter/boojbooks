<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Storage;

class Book extends Model
{
	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'title', 'author', 'publication_date', 'description', 'rating', 'image_ext'
	];
	
	/**
	 * Save the uploaded image
	 *
	 * @param string $realpath The real server path to the uploaded file 
	 */
	public function setImage($realpath = ''){
		$fileinfo = new SplFileInfo($realpath);
		$ext = $fileinfo->getExtension();
		
		$imagepath = "images/{$this->id}.$ext";
		Storage::set($imagepath, file_get_contents($realpath));
		$this->image_ext = $ext;
		$this->save();
	}
	
	/**
	 * Get the raw image data for this book
	 * 
	 */
	public function getImage(){
		$imagepath = "images/{$this->id}.{$this->image_ext}";
		if(Storage::exists($imagepath)){
			return Storage::get($imagepath);
		}
	}
}
