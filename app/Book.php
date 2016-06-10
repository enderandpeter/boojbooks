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
	 * An array of Book attributes that are suitable for most views
	 * 
	 * @return array
	 */
	public function getDisplayable(){
		return array_diff($this->fillable, ['image_ext', 'booklist_id']);
	}
	
	/**
	 * Split a snake case word into first-letter uppercased, space-delimited words
	 * 
	 * @param string $word
	 */
	public static function splitWords($word = ''){
		return ucwords( str_replace( '_', ' ', $word ) );
	}
	
	/**
	 * Save the uploaded image
	 *
	 * @param string $realpath The real server path to the uploaded file
	 * @param string $clientpath The client-provided path to the file which contains the original file extension 
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
	 * @return resource
	 */
	public function getRawImage(){
		$imagepath = $this->getImagePath();
		if(Storage::exists($imagepath)){
			return Storage::get($imagepath);
		}
	}
	
	/**
	 * Get the url of the book's image
	 *
	 * @return string
	 */
	public function getImageUrl(){
		$imagepath = $this->getImagePath();
		if(Storage::exists($imagepath)){
			return Storage::url($imagepath);
		}
	}
	
	/**
	 * Whether or not this book's image exists
	 *
	 * @return boolean
	 */
	public function hasImage(){
		$imagepath = $this->getImagePath();
		if(Storage::exists($imagepath)){
			return Storage::exists($imagepath);
		}
	}
	
	/**
	 * Get the raw image data for this book
	 *
	 */
	public function getImagePath(){
		return $imagepath = "images/{$this->id}.{$this->image_ext}";		
	}
}
