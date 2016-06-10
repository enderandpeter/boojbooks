<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Book;
use App\Booklist;
use Carbon\Carbon;

use Storage;

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
    	$booklist = Booklist::findOrFail( $request->route('booklist') ); 
    	
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
    	$new_publication_date = Carbon::parse($request->input('publication_date'))->format('Y-m-d');
    	$request->replace(array_merge($request->all(), ['publication_date' => $new_publication_date]));    	 
    	
    	$this->validate($request, [
    			'title' => 'required|max:255|string',
    			'author' => 'required|max:255|string',
    			'publication_date' => 'required|date',
    			'description' => 'string|max:1000',
    			'rating' => 'numeric|max:5',
    			'image' => 'image|dimensions:min_width=5,min_height=5,max_width=1000,max_height=1000'
    	]);
    	
    	$booklistid = $request->route('booklist');
    	$booklist = Booklist::findOrFail($booklistid);
    	
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
        	'booklist' => Booklist::findOrFail($booklistid), 
        	'book' => Book::findOrFail($bookid)
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
        	'booklist' => Booklist::findOrFail($booklistid),
        	'book' => Book::findOrFail($bookid),
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
    	$new_publication_date = Carbon::parse($request->input('publication_date'))->format('Y-m-d');
    	$request->replace(array_merge($request->all(), ['publication_date' => $new_publication_date]));
    	
        $this->validate($request, [
    			'title' => 'required|max:255|string',
    			'author' => 'required|max:255|string',
    			'publication_date' => 'date',
    			'description' => 'string|max:1000',
    			'rating' => 'numeric|max:5'
    	]);
    	
    	$book = Book::findorFail($bookid);
    	
    	$message = "{$book->title} was updated!";
    	
    	$book->title = $request->input('title');
    	$book->author = $request->input('author');
    	$book->publication_date = $request->input('publication_date');
    	$book->description = $request->input('description');
    	$book->rating = $request->input('rating');
    	
    	$book->save();
    	
    	if($request->hasFile('image')){
    		$book->setImage($request->file('image')->getRealPath(), $request->file('image')->getClientOriginalName());
    	}
    	
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
        $book = Book::findOrFail($bookid);
    	
    	$message = "{$book->title} was deleted!";        
        
        $book->delete();
        
        if($book->hasImage()){
        	Storage::delete($book->getImagePath());
        }
        
        return redirect( route('booklist.show', [ 'booklist' => $booklistid ]) )->with('status', [ 
        		'message' => $message, 
        		'type' => 'warning'
        ]);
    }
}
