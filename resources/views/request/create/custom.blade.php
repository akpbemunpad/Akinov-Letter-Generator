@extends('layouts.app')

@section('content')
  <div class="row">
    <div class="col-lg-5">
      <h3>Create a custom letter.</h3>
      <hr>
    </div>
  </div>

  <div class="row">
    <div class="col-lg-5">
      <div class="alert alert-warning" role="alert">
        Selain Fikri dilarang ada yang isi halaman ini!
      </div>
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
      <form action="<?= url('/' . $letterType . '/custom') ?>" method="post" autocomplete="off">
        @csrf
        <div class="form-group">
          <label for="letter_ref_number">Letter Ref Number: </label>
          <input type="number" class="form-control" name="letter_ref_number" id="letter_ref_number">
        </div>
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

