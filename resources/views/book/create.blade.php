@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading"> Create a new Reading list </div>
                <div class="panel-body">
                	<form id="create_book_booklist_{{ $booklist->id }}" action="{{ route( 'booklist.book.create', $booklist->id ) }}" method="post">
                		<div class="form-group">
                		<label for="name">Title</label>
    					<input type="text" maxlength="255" class="form-control" id="title" name="title" placeholder="Title">
    					<input type="text" maxlength="255" class="form-control" id="author" name="author" placeholder="Author">
    					<input type="date" maxlength="255" class="form-control" id="publication_date" name="publication_date" placeholder="Publication Date">
    					<input type="file" class="form-control" id="image" name="image" accept="image/*">
    					<textarea type="text" maxlength="1000" class="form-control" id="description" name="description" placeholder="Description"></textarea>
    					<input type="number" min="0" max="5" class="form-control" id="rating" name="rating">
    					<button type="submit" name="submit" class="btn btn-default">Add book</button>
                		</div>
                		{{ csrf_field() }}
                	</form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection