@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading"> {{ $book->title }}</strong> </div>
                <div class="panel-body">
                	<div class="container-fluid">
                		<div class="row">
                			<h2 class="book_show_title" id="book_title_{{ $book->id }}">{{ $book->title }}</h2>                		
                		<?php 
                			$imagepath = 'images/' . $book->id . '.' . $book->image_ext;
                		?>
                		@if ( Storage::exists($imagepath) )
                			<img src="{{ asset('storage/' .$imagepath) }}" id="book_image_{{ $book->id }}">
                		@endif
                		</div>
                		<div class="row">
                			<h3 class="attribute_label">Author</h3>
                			<h4 class="book_author" id="book_author_{{ $book->id }}">{{ $book->author }}</h4> 
                		</div>
                		<div class="row">
                			<h3 class="attribute_label">Publication Date</h3>
                			<h4 class="book_publication_date" id="book_publication_date_{{ $book->id }}">{{ $book->publication_date }}</h4> 
                		</div>
                		<div class="row">
                			<h3 class="attribute_label">Description</h3>
                			<div class="book_description" id="book_description_{{ $book->id }}">
                				<p>
                				{{ $book->description }}
                				</p>
                			</div>
                		</div>
                		<div class="row">
                			<h3 class="attribute_label">Rating</h3>
                			<div class="book_rating" id="book_rating_{{ $book->id }}">
                				{{ $book->rating }}
                			</div>
                		</div>
                	</div>                	
                </div>
            </div>
        </div>
    </div>
</div>
@endsection