@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading"> Create a new Reading list </div>
                <div class="panel-body">
                	<form enctype="multipart/form-data" id="store_book_booklist_{{ $booklist->id }}" action="{{ route( 'booklist.book.store', $booklist->id ) }}" method="post">
                		<div class="form-group">
	                		<label for="name">Title</label>
	    					<input type="text" maxlength="255" class="form-control" id="title" name="title" value="{{ old('title') }}" placeholder="Title">
    					</div>
    					<div class="form-group">
	    					<label for="author">Author</label>
	    					<input type="text" maxlength="255" class="form-control" id="author" name="author" value="{{ old('author') }}" placeholder="Author">
    					</div>
    					<div class="form-group">
    						<label for="publication_date">Publication Date</label>
    						<input type="date" class="form-control" id="publication_date" name="publication_date" value="{{ old('date') }}" placeholder="Publication Date">
    					</div>
    					<div class="form-group">
    						<label for="image">Book Cover</label>
    						<input type="file" class="form-control" id="image" name="image" accept="image/*" value="{{ old('image') }}">
    					</div>    					    					
    					<textarea type="text" maxlength="1000" class="form-control" id="description" name="description" placeholder="Description">{{ old('description') }}</textarea>
    					<div class="form-group">
	    					<label for="rating">Rating</label>
	    					<input type="number" min="0" max="5" class="form-control" id="rating" name="rating" value="{{ old('rating') }}">
    					</div>    					
    					<button type="submit" name="submit" class="btn btn-default">Add book</button>
                		
                		{{ csrf_field() }}
                	</form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection