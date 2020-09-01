@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col">
            <h3>Konfirmasi penghapusan surat permanen.</h3>
            <hr>
        </div>
    </div>

    <div class="row">
        <div class="col">
            <form action="{{ url('/' . $letterType) }}" method="post">
                @csrf
                @method('DELETE')
                <div class="form-group">
                    <span>
                        Apakah anda yakin ingin menghapus surat <b>{{ $letter->file_name }}</b> ?
                        <input type="hidden" name="letterId" value="{{ $letter->id }}">
                        <input type="hidden" name="letterFileId" value="{{ $letter->file_name }}">
                    </span>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-danger">Ya, saya yakin</button>
                    <a href="{{ url('/') }}" type="button" class="btn btn-secondary">Tidak, saya ingin membatalkan</a>
                </div>
            </form>
        </div>
    </div>
@endsection