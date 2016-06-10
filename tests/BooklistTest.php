<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use App\User;
use App\Book;
use App\Booklist;

/**
 * Test the basic functionality of creating and managing reading lists
 * 
 * @author Spencer
 *
 */
class BooklistTest extends TestCase
{
	use DatabaseMigrations;
	
    /**
     * Test creating a booklist with the form.
     *
     * @return void
     */
    public function testCreateBooklistForm()
    {
    	/*
    	 * Create the fake user
    	 */
    	$user = factory(User::class)->create();
    	
    	/*
    	 * Visit the home page as a logged-in user and create a new reading list
    	 */
    	$this->actingAs($user)
    		->visit('/')
    		->see('You are logged in!')
    		->seeElement('#booklist_create')
    		->click('Add a reading list')
    		->see('Create a new Reading list')
    		->type('a list', 'name')
    		->press('submit')
    		->see('Reading List a list was created!');
    }
    
    /**
     * Make sure empty fields return the expected errors
     *
     * @return void
     */
    public function testCreateEmptyFields()
    {    	 
    	/*
    	 * Create the fake user
    	 */
    	$user = factory(User::class)->create();
    	
    	/*
    	 * Confirm the error text when submitting empty fields to the registration form
    	 */
    	$this->actingAs($user)
    	->visit( route( 'booklist.create' ) )
    	->see('Create a new Reading list')
    	->type('', 'name')
    	->press('submit')
    	->see('The name field is required.');
    	
    	$this->assertTrue($user->booklists->isEmpty());
    	 
    	/*
    	 * Confirm the error session keys when explicitly posting the registration form
    	 */
    	 
    	$this->post( route( 'booklist.store' ), [
    			'name' => '',
    			'_token' => csrf_token()
    	])
    	->assertRedirectedToRoute('booklist.create')
    	->assertSessionHasErrors(['name']);
    	
    	$this->assertTrue($user->booklists->isEmpty());
    }
    
    /**
     * Test the maximum length restraints for the create form
     *
     * @return void
     */
    public function testCreateMaxLength(){
    	/*
    	 * Create the fake user
    	 */
    	$user = factory(User::class)->create();
    	 
    	/*
    	 * Confirm the error text when submitting oversized data
    	 */
    	$name = str_random(256);
    	$this->actingAs($user)
    		->visit( route( 'booklist.create' ) )
    		->type($name , 'name')
    		->press('submit')
    		->see('The name may not be greater than 255 characters.');
    		
    	$this->assertTrue($user->booklists->isEmpty());
    	
    	/*
    	 * Confirm the error session keys when explicitly posting the registration form
    	 */
    		 
    	$this->post( route( 'booklist.store' ), [
    			'name' => $name, 
    			'_token' => csrf_token()
    		])
    		->assertRedirectedToRoute('booklist.create')
    		->assertSessionHasErrors(['name']);
    	
    	$this->assertTrue($user->booklists->isEmpty());
    }
    
    /**
     * Confirm that booklists appear on the user's homepage when models are created
     * 
     * @return void
     */
    public function testDisplayBooklists(){
    	/*
    	 * Create the fake user
    	 */
    	$user = factory(User::class)->create();
    	
    	/*
    	 * Create three new book lists
    	 */
    	$booklists = factory(Booklist::class, 3)->create(
    			[ 'user_id' => $user->id ]
    	);    	
    	
    	/*
    	 * Confirm that the text to add additional reading list appears when the user has at least one
    	 */
    	$this->actingAs($user)
    		->visit('/')
    		->seeInElement('#booklist_create', 'Add another reading list');
    	
    	/*
    	 * Confirm display of the reading list names and inital book count
    	 */
    	$booklists->each(function($b){
    		$this->seeInElement('#book_count_' . $b->id, '0')
    			 ->seeInElement('#booklist_show_' . $b->id, $b->name);
    	});
    }
    
    /**
     * Confirm that a single booklist displays as expected
     *
     * @return void
     */
    public function testDisplayBooklist(){
    	/*
    	 * Create the fake user
    	 */
    	$user = factory(User::class)->create();
    	 
    	/*
    	 * Create three new book lists
    	 */
    	$booklist = factory(Booklist::class)->create(
    			[ 'user_id' => $user->id ]
    	);
    	
    	/*
    	 * Confirm that the text to add additional reading list appears when the user has at least one
    	 */
    	$this->actingAs($user)
	    	->visit( route( 'booklist.show', $booklist->id ) )
	    	->see($booklist->name)
    		->see('Add a book');
    }
    
    /**
     * Confirm the expected behavior of the form for editing a booklist
     * 
     * @return void
     */
    public function testEditBooklist(){
    	/*
    	 * Create a new book
    	 */
    	$booklist = factory(BookList::class)->create();
    	$oldname = $booklist->name;
    	
    	$newname = str_random(10);
    	
    	$this->visit( route( 'booklist.edit', $booklist->id ) )
    		->see('Edit ' . $booklist->name)
    		->type($newname, 'name')
    		->press('submit')
    		->see("Reading List $oldname was updated!");
    	
    	$this->assertFalse(Booklist::where('name', $newname)->get()->isEmpty());
    }
    
    /**
     * Test behavior with empty fields when updating a booklist
     * 
     * @return void
     */
    public function testEditEmptyFields(){    	 
    	$booklist = factory(BookList::class)->create();
    	$user = User::findOrFail($booklist->user_id)->first();
    	
    	/*
    	 * Confirm the error text when submitting empty fields to the registration form
    	 */
    	$this->actingAs($user)
    		->visit( route( 'booklist.edit', $booklist->id ) )
	    	->see('Edit ' . $booklist->name)
	    	->type('', 'name')
	    	->press('submit')
	    	->see('The name field is required.');
    	 
    	/*
    	 * Confirm the error session keys when explicitly posting the registration form
    	 */
    	 
    	$this->call('put', route( 'booklist.update', $booklist->id ), [
    			'name' => '',
    			'_token' => csrf_token()
    	]);
    	$this->assertRedirectedToRoute( 'booklist.edit', [ $booklist->id ] )
    	->assertSessionHasErrors(['name']);
    }
    
    /**
     * Test the maximum length restraints for the edit form
     *
     * @return void
     */
    public function testEditMaxLength(){
    	$booklist = factory(BookList::class)->create();
    	$user = User::findOrFail($booklist->user_id)->first();
    	
    	/*
    	 * Visit the registration page and enter fields that are too long
    	 */
    	$this->actingAs($user)
    		->visit( route( 'booklist.edit', $booklist->id ) )
    		->see('Edit ' . $booklist->name);
    	 
    	/*
    	 * Confirm the error text when submitting oversized data
    	 */
    	$name = str_random(256);
    	
    	$this->type($name , 'name')
	    	->press('submit')
	    	->see('The name may not be greater than 255 characters.');
    	 
    	/*
    	 * Confirm the error session keys when explicitly posting the registration form
    	 */
    	 
    	$this->call('put',  route( 'booklist.update', $booklist->id ), [
    			'name' => $name,
    			'_token' => csrf_token()
    	]);
		$this->assertRedirectedToRoute( 'booklist.edit', [ $booklist->id ] )
	    	->assertSessionHasErrors(['name']);
    }
}
