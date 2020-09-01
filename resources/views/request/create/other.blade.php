@extends('layouts.app')

@section('content')
  <div class="row">
    <div class="col-lg-5">
        @if( $job == 'create' )
            <h3>Create an other letter.</h3>
        @elseif ( $job == 'edit' )
            <h3>Edit an other letter.</h3>
        @endif
      <hr>
    </div>
  </div>

@if($errors->any())
  @foreach ($errors->all() as $error)
  <div class="row">
    <div class="col-lg-5">
      <div class="alert alert-danger" role="alert">
        {{ $error }}
      </div>
    </div>
  </div>
  @endforeach
@endif

@if(isset($result))
  <div class="row">
    <div class="col-lg-5">
      <div class="alert alert-{{ $result }}" role="alert">
        {{ $message }}
      </div>
    </div>
  </div>
@endif

  <div class="row">
    <div class="col-lg-5">
      <form action="<?= url('/other/' . $job) ?>" method="post">
        @csrf
        <input type="hidden" name="id" value="{{ $letter->id ?? '' }}">
        <div class="form-group">
          <label for="file_name">File Name: </label>
          <input type="text" class="form-control" name="file_name" id="file_name">
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
      </form>
    </div>
  </div>

  <div class="row my-4">
  </div>
@endsection

