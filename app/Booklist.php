<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Booklist extends Model
{	
	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
			'name', 'user_id'
	];
	
    /**
     * Get the books for this booklist
     */
	public function books()
	{
		return $this->hasMany('App\Book');
	}
}
