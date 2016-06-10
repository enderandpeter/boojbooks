<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Storage;
use SplFileInfo;

class Book extends Model
{
	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'title', 'author', 'publication_date', 'description', 'rating', 'image_ext', 'booklist_id'
	];
	
	/**
	 * Save the uploaded image
	 *
	 * @param string $realpath The real server path to the uploaded file
	 * @param string $clientpath The client-provided path to the file which contains the origain file extension 
	 */
	public function setImage($realpath = '', $clientpath = ''){
		// Only proceed if given actual file paths.
		if(empty($realpath) || empty($clientpath)){
			return;
		}
		
		$fileinfo = new SplFileInfo($clientpath);
		$ext = $fileinfo->getExtension();
		
		$imagepath = "images/{$this->id}.$ext";
		Storage::put($imagepath, file_get_contents($realpath));
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
