@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading"> Edit <strong>{{ $book->title }}</strong> </div>
                <div class="panel-body">
                	<form enctype="multipart/form-data" id="update_book_booklist_{{ $booklist->id }}" action="{{ route( 'booklist.book.update', [ $booklist->id, $book->id ] ) }}" method="post">
                		@foreach ($displayAttributes as $attribute) 
	                		<?php 
	                			$inputType = 'text';
	                			$input = 'input';
	                			
	                			$attributes = ' required maxlength="255" ';
	                		?>               			
                			@if ( $attribute === 'publication_date' )
                				<?php 
                					$inputType = 'date';
                					$attributes = ' required ';
                				?>
                			@endif
                			
                			@if ( $attribute === 'description' )
                				<?php 
                					$input = 'textarea';
                					$attributes = ' maxlength="1000" ';
                				?>
                			@endif
                			
                			@if ( $attribute === 'rating' )
                				<?php 
                					$inputType = 'number';
                					$attributes = ' min=1 max=5 ';
                				?>
                			@endif
                			
                			@if ( $attribute === 'publication_date' )
                				<?php 
                					$inputType = 'date';
                				?>
                			@endif
                			
                			<?php 
                				$heading = App\Book::splitWords($attribute);
                				$attributes .= " class=form-control id=$attribute name=$attribute placeholder=$heading";
                			?>
                			
                			<div class="form-group">
		                		<label for="{{ $attribute }}">{{ App\Book::splitWords($attribute) }}</label>
		                		@if ( $input === 'textarea' )
		                			<textarea type="text"{{ $attributes }}>{{ old('description') ? old('description') : $book->description }}</textarea>
		                		@else
		                			<input type="{{ $inputType }}"{{ $attributes }} value="{{ old($attribute) ? old($attribute) : $book->$attribute }}">
		                		@endif		    					
    						</div>                			
                		@endforeach                		
    					<div class="form-group">
    						<label for="image">Book Cover</label>
    						<input type="file" class="form-control" id="image" name="image" accept="image/*" value="{{ old('image') }}">
    					</div>		
    					<button type="submit" name="submit" class="btn btn-default">Edit book</button>
                		{{ method_field('PUT') }}
                		{{ csrf_field() }}
                	</form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection