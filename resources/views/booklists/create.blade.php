@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading"> Create a new Reading list </div>
                <div class="panel-body">
                	<form id="create_booklist" action="/booklist" method="post">
                		<div class="form-group">
                		<label for="name">Name</label>
    					<input type="text" maxlength="255" class="form-control" id="name" name="name" placeholder="Name">
    					<button type="submit" class="btn btn-default">Create new reading list</button>
                		</div>
                		{{ csrf_field() }}
                	</form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection