<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\BookList;
use App\Book;
use Doctrine\Common\Collections\Collection;

class BooklistController extends Controller
{
	
	/**
	 * Instantiate a new BooklistController class
	 * 
	 * @return void
	 */
	public function __construct(){
		$this->middleware('auth', [ 'except' => [
			'show'	
		]]);
	}
	
	/**
	 * Gets a book's displayable attributes
	 * 
	 * @param \Illuminate\Database\Eloquent\Collection $books The list of books 
	 * @return array|null
	 */
	public function getDisplayableAttributes($books = null){
		if(empty($books)){
			
		}
		
		$displayableAttributes = null;
		
		if( ! $books->isEmpty() ){
    		$displayableAttributes = $books[0]->getDisplayable();
    	}
		return $displayableAttributes;
	}
	
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    	return view('dashboard');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('booklists.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
        	'name' => 'required|max:255'
        ]);
        
        $message = "Reading List {$request->name} was created!";
        
        $createData = [
        	'name' => $request->input('name'),
        	'user_id' => $request->user()->id
        ];
        
        BookList::create($createData);
        
        return redirect('/')->with('status', [ 'message' => $message ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
    	$booklist = Booklist::findorFail($id);    	
    	
        return view('booklists.show', [
        	'booklist' => $booklist,
        	'displayableAttributes' => (new Book)->getDisplayable()
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
    	return view('booklists.edit', [
    		'booklist' => Booklist::findorFail($id)
    	]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
    	$this->validate($request, [
    			'name' => 'required|max:255'
    	]);
    	
    	$booklist = Booklist::findOrFail($id);
    	
    	$message = "Reading List {$booklist->name} was updated!";
    	
    	$booklist->name = $request->input('name');
    	
    	$booklist->save();
    	
    	return redirect( route( 'booklist.show', $id ) )->with('status', [ 'message' => $message ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
    	$booklist = Booklist::findOrFail($id);
    	
    	$message = "Reading List {$booklist->name} was deleted!";        
        
        $booklist->delete();
        
        return redirect('/')->with('status', [ 
        		'message' => $message, 
        		'type' => 'warning'
        ]);
    }
}
