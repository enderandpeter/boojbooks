<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Book;
use App\Booklist;

class BookController extends Controller
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
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
    	$booklist = Booklist::findOrFail( $request->route('booklist') )->first(); 
    	
        return view('book.create', [
         	'booklist'	=> $booklist,
        	'displayAttributes' => (new Book)->getDisplayable()
        		
        ]);
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
    			'title' => 'required|max:255|string',
    			'author' => 'required|max:255|string',
    			'publication_date' => 'required|date',
    			'description' => 'string|max:1000',
    			'rating' => 'numeric|max:5',
    			'image' => 'image|dimensions:min_width=5,min_height=5,max_width=1000,max_height=1000'
    	]);
    	
    	$booklistid = $request->route('booklist');
    	$booklist = Booklist::findOrFail($booklistid)->first();
    	
    	$message = "Added {$request->title} to Reading List {$booklist->name}!";
    	
    	$createData = array_merge($request->all(), [ 'booklist_id' => $booklist->id ]);
    	
    	$book = Book::create($createData);
    	
    	if($request->hasFile('image')){
    		$book->setImage($request->file('image')->getRealPath(), $request->file('image')->getClientOriginalName());
    	}
    	
    	return redirect( route('booklist.show', $booklist->id ) )->with('status', [ 'message' => $message ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($booklistid, $bookid)
    {
        return view('book.show', [
        	'booklist' => Booklist::findOrFail($booklistid)->first(), 
        	'book' => Book::findOrFail($bookid)->first()
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($booklistid, $bookid)
    {
        return view('book.edit', [
        	'booklist' => Booklist::findOrFail($booklistid)->first(),
        	'book' => Book::findOrFail($bookid)->first(),
        	'displayAttributes' => (new Book)->getDisplayable()
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $booklistid, $bookid)
    {
        $this->validate($request, [
    			'title' => 'required|max:255|string',
    			'author' => 'required|max:255|string',
    			'publication_date' => 'date',
    			'description' => 'string|max:1000',
    			'rating' => 'numeric|max:5'
    	]);
    	
    	$book = Book::findorFail($id)->get();
    	
    	$message = "{$book->title} was updated!";
    	
    	$updateData = $request->all();
    	
    	$booklist->save($updateData);
    	
    	return redirect( route('booklist.book.show', [ 'booklist' => $booklistid, 'book' => $bookid ]) )->with('status', [ 'message' => $message ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($booklistid, $bookid)
    {
        $booklist = Book::findOrFail($bookid);
    	
    	$message = "{$book->title} was deleted!";        
        
        $booklist->delete();
        
        return redirect( route('booklist.book.show', [ 'booklist' => $booklistid, 'book' => $bookid ]) )->with('status', [ 
        		'message' => $message, 
        		'type' => 'warning'
        ]);
    }
}
