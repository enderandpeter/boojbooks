@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading"> {{ $booklist->name }} - <a href="{{ route( 'booklist.edit', $booklist->id ) }}">Edit</a> </div>
                <div class="panel-body">
                	@if( ! $booklist->books->isEmpty() )
                	<ul class="list-group booklist" id="booklist_{{ $booklist->id }}">
                		@foreach ( $booklist->books as $book )
                			<li class="list-group-item">
                				<h2 class="book_title" id="book_title_{{ $book->id }}">{{ $book->title }}</h2>
                				<h3 class="book_author" id="book_author_{{ $book->id }}">{{ $book->author }}</h3>
                				<h4 class="book_publication_date" id="book_publication_date_{{ $book->id }}">{{ $book->publication_date }}</h4>
                				<div class="book_description" id="book_description_{{ $book->id }}">
                					{{ $book->description }}
                				</div>
                				<div class="book_rating" id="book_rating_{{ $book->id }}">
                					{{ $book->rating }}
                				</div>
                			</li>
                		@endforeach
                	</ul>
                	@endif
                	<div id="add_books_div">
                		<a href="{{ route( 'booklist.book.create', $booklist->id ) }}" id="booklist_book_create">Add a book</a>
                	</div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection