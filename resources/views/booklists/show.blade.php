@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading"> {{ $booklist->name }} - <a href="{{ route( 'booklist.edit', $booklist->id ) }}">Edit</a> </div>
                <div class="panel-body">
                	@if( ! $booklist->books->isEmpty() )                		
                		@if ( request('view') !== 'list' )                		
                	<table class="table table-striped booklist_table" id="booklist_table_{{ $booklist->id }}">
                		<thead>
                			<tr>
                			@foreach ( $displayableAttributes as $heading )                				
                				<th>{{ ucwords( str_replace( '_', ' ', $heading ) ) }}</th>                				
                			@endforeach
                				<th>Controls</th>
                			</tr>
                		</thead>
                		<tbody>
                			@foreach ( $booklist->books as $book )
                				@foreach ( $displayableAttributes as $attribute )
                				<td id="book_{{ $attribute }}_{{ $book->id }}">
                					@if ( $attribute === 'title' )
                						<a href="{{ route('booklist.book.show', [ $booklist->id, $book->id ]) }}">{{ $book->$attribute }}</a>
                					@else
                						{{ $book->$attribute }}
                					@endif
                					 
                				</td>
                				@endforeach
                				<td id="book_controls_{{ $book->id }}">
                					{{--  Separate forms are required to provide for the different method_field() spoofing --}}
                					<div class="btn-group">
                						<a class="btn btn-default" title="Edit" href="{{ route( 'booklist.book.edit', [ $booklist->id , $book->id ] ) }}" id="book_edit_form_{{ $book->id }}"> 
                							<span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
                						</a>
                						<form class="pull-left" action="{{ route( 'booklist.book.destroy', [ $booklist->id , $book->id ] ) }}" id="book_destroy_form_{{ $book->id }}" method="post">
	                						<button title="Delete" type="submit" name="submit" id="book_destroy_button_{{ $book->id }}" class="btn btn-default">
	                							<span class="glyphicon glyphicon-trash" aria-hidden="true"></span>                							
	                						</button>
	                						{{ method_field('DELETE') }}
	                						{{ csrf_field() }}
                						</form>                						
                					</div> 
                				</td>
                			@endforeach
                		</tbody>
                	</table>
                		@endif
                		
                		@if ( request('view') === 'list' )                	
                	<ul class="list-group booklist" id="booklist_{{ $booklist->id }}">
                		@foreach ( $booklist->books as $book )
                			<li class="list-group-item">
                				<a href="{{ route('booklist.book.show', [ $booklist->id, $book->id ]) }}"><h2 class="book_title" id="book_title_{{ $book->id }}">{{ $book->title }}</h2></a>
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