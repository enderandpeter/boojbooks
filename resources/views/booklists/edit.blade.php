@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading"> Edit {{ $booklist->name }}</div>
                <div class="panel-body">
                	<form id="update_booklist" action="{{ route( 'booklist.update', $booklist->id ) }}" method="post">
                		<div class="form-group">
                		<label for="name">Name</label>
    					<input type="text" maxlength="255" class="form-control" id="name" name="name" placeholder="Name" autofocus="autofocus" value="{{ $booklist->name }}">
    					<button type="submit" name="submit" class="btn btn-default">Edit</button>
                		</div>
                		{{ csrf_field() }}
                		{{ method_field('PUT') }}
                	</form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection