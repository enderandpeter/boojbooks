@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard - My Books</div>

                <div class="panel-body">
                    You are logged in!
                    @if ( auth()->user()->booklists->isEmpty() )
                    	<a href="{{ route( 'booklist.create' ) }}" id="booklist_create">Add a reading list</a> to get started.	
                    @else
                    	<a href="{{ route( 'booklist.create' ) }}" id="booklist_create">Add another reading list</a> when you're ready!
                    	<div class="container-fluid">
                    		<?php $count = 0; ?>
                    		@foreach ( auth()->user()->booklists as $booklist )
                    			@if ( ! $count % 3 ) 
                    				<div class="row">                   				
                    			@endif
                    			
                    			<div class="col-md-4" id="booklist_{{ $booklist->id }}">
                    				<div class="booklist_name"><a href="{{ route( 'booklist.show', $booklist->id ) }}" id="booklist_show_{{ $booklist->id }}">{{ $booklist->name }}</a> <span class="badge book_count" id="book_count_{{ $booklist->id }}">{{ $booklist->books->count() }}</span></div>
                    				<div class="booklist_controls">
                    					<a href="{{ route( 'booklist.edit', $booklist->id ) }}">Edit</a>
                    					<form class="booklist_delete" action="{{ route( 'booklist.destroy', $booklist->id ) }}" method="post">
                    						<button type="submit">Delete</button>
                    						{{ csrf_field() }}
                    						{{ method_field('DELETE') }}
                    					</form>
                    				</div>	
                    			</div>
                    			                    			
                    			@if ( ! ($count + 1) % 3 ) 
                    				</div>
                    			@endif
                    			<?php $count++; ?>
                    		@endforeach
                    	</div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
