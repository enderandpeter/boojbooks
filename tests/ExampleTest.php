<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

/**
 * A basic example of how a typical user experience should go on Booj Reading List.
 * 
 * @author Spencer
 *
 */
class ExampleTest extends TestCase
{
	use DatabaseMigrations;
    /**
     * Run through a basic functional test example.
     *
     * @return void
     */
    public function testBasicExample()
    {
    	/*
    	 * Visit the site with middleware enabled. The user should see the generic greeting.
    	 */
        $this->visit('/')
             ->see('Welcome to Booj Reading List!');
        
             
        /*
         * Create a user for registration
         */
        $clearpass = str_random(10);
        $user = factory(App\User::class)->make([
        	'password' => bcrypt($clearpass)	
        ]);
        
        /*
         * Visit the Registration page and confirm unique content
         */
       $this->visit('/register')
       		->see('E-Mail Address');
       
       		
       /*
        * Confirm the error text when submitting empty fields to the registration form
        */
       $this->type('', 'name')
       		->type('', 'email')
       		->type('', 'password')
       		->type('', 'password_confirmation')
       		->press('Register')
       		->see('The name field is required.')
       		->see('The email field is required.')
       		->see('The password field is required.');
       
       /*
        * Confirm the "error" session keys when explicitly posting the registration form
        */
       		
       		$this->post('/register', ['name' => '', 'email' => '', 'password' => '', 'password_confirmation' => ''])
       		->assertRedirectedTo('/register')
       		->assertSessionHasErrors(['name', 'email', 'password']);
    }
}
