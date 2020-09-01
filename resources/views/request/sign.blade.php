@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col">
            <h3>Letter Signing Confirmation.</h3>
            <hr>
        </div>
    </div>

    <div class="row">
        <div class="col">
            <form action="{{ url('/sign/' . $letterType) }}" method="post">
                @csrf
                <div class="form-group">
                    <span>
                        Apakah anda yakin ingin menandatangani surat <b>{{ $letter->file_name }}</b> ?
                        <input type="hidden" name="letter_id" value="{{ $letter->id }}">
                        <input type="hidden" name="letter_file_name" value="{{ $letter->file_name }}">
                    </span>
                    @if( $preview )
                        <div class="embed-responsive embed-responsive-4by3">
                            <iframe class="embed-responsive-item" src="https://docs.google.com/gview?url={{ url('storage\\' . $letter->file_name) }}&embedded=true"></iframe>
                        </div>
                    @endif
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-success">Ya, saya yakin</button>
                    <a href="{{ url('/') }}" type="button" class="btn btn-secondary">Tidak, saya ingin membatalkan</a>
                </div>
            </form>
        </div>
    </div>
@endsection