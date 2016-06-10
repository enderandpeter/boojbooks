<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Book;

class BookController extends Controller
{
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
         return view('book.create');
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
    			'publication_date' => 'date',
    			'description' => 'string|max:1000',
    			'rating' => 'numeric|max:5'
    	]);
    	
    	$booklistid = $request->route('booklist');
    	$booklist = Booklist::findOrFail($booklistid)->get();
    	
    	$message = "Added {$request->title} to Reading List {$booklist->name}!";
    	
    	$createData = array_merge($request->all(), [ 'booklist_id' => $booklistid ]);
    	
    	BookController::create($createData);
    	
    	return back()->with('status', [ 'message' => $message ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return view('book.show', [
        	'book' => Book::findOrFail($id)->get()
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
        return view('book.edit', [
        	'book' => Book::findOrFail($id)->get()
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
    	
    	return back()->with('status', [ 'message' => $message ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $booklist = Book::findOrFail($id);
    	
    	$message = "{$book->title} was deleted!";        
        
        $booklist->delete();
        
        return back()->with('status', [ 
        		'message' => $message, 
        		'type' => 'warning'
        ]);
    }
}
