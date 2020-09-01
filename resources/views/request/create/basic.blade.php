@extends('layouts.app')

@section('content')
  <div class="row">
    <div class="col-lg-5">
      @if( $job == 'create' )
        <h3>Buat surat-surat dasar.</h3>
      @elseif ( $job == 'edit' )
        <h3>Sunting surat-surat dasar.</h3>
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

  <div class="row">
    <div class="col-lg-5">
      <form action="<?= url('/basic/' . $job ) ?>" method="post">
        @csrf
        <input type="hidden" name="id" value="{{ $letter->id ?? '' }}">
        <div class="form-group">
          @if( $job == 'create' )
            <label>Divisi: </label>
            <div class="form-check">
              <input class="form-check-input" type="radio" id="akpres" name="division" value="1" @if(isset($letter->division)) {{ $letter->division == 1 ? 'checked' : ''}} @endif>
              <label class="form-check-label" for="akpres">
                Akademik dan Prestasi
              </label>
            </div>
            <div class="form-check">
              <input class="form-check-input" type="radio" id="inovasi" name="division" value="2" @if(isset($letter->division)) {{ $letter->division == 2 ? 'checked' : ''}} @endif>
              <label class="form-check-label" for="inovasi">
                Inovasi
              </label>
            </div>
            <div class="form-check">
              <input class="form-check-input" type="radio" id="medfo" name="division" value="3" @if(isset($letter->division)) {{ $letter->division == 3 ? 'checked' : ''}} @endif>
              <label class="form-check-label" for="medfo">
                Media Informasi
              </label>
            </div>
            <div class="form-check">
              <input class="form-check-input" type="radio" id="pubrel" name="division" value="4" @if(isset($letter->division)) {{ $letter->division == 4 ? 'checked' : ''}} @endif>
              <label class="form-check-label" for="pubrel">
                Relasi Publik
              </label>
            </div>
          </div>
        @endif
        <div class="form-group">
          <label for="event_name">Nama kegiatan: </label>
          <input type="text" class="form-control" name="event_name" id="event_name" placeholder="mis: Comblangin Inovasi" value="{{ $letter->event_name ?? '' }}">
        </div>
        <div class="form-group">
          <label for="event_description">Deskripsi kegiatan: </label>
          <input type="text" class="form-control" name="event_description" id="event_description" placeholder="mis: merupakan proker untuk menginkubasi..." value="{{ $letter->event_description ?? '' }}">
          <small class="form-text text-muted">Singkat saja.</small>
        </div>
        <div class="form-group">
          <label for="event_date">Tanggal kegiatan: </label>
          <input type="text" class="form-control" name="event_date" id="event_date" placeholder="mis: Minggu, 1 Januari - Sabtu, 20 November 2020" value="{{ $letter->event_date ?? '' }}">
        </div>
        <div class="form-group">
          <label for="event_time">Waktu kegiatan: </label>
          <input type="text" class="form-control" name="event_time" id="event_time" placeholder="mis: 22.00 - 00.00 WIB" value="{{ $letter->event_time ?? '' }}">
        </div>
        <div class="form-group">
          <label for="event_place">Tempat kegiatan: </label>
          <input type="text" class="form-control" name="event_place" id="event_place" placeholder="mis: secara daring melalui platform Zoom" value="{{ $letter->event_place ?? '' }}">
        </div>
        <div class="form-group">
          <label for="cp_name">Nama singkat narahubung: </label>
          <input type="text" class="form-control" name="cp_name" id="cp_name" placeholder="mis: Dwisya" value="{{ $letter->cp_name ?? '' }}">
        </div>
        <div class="form-group">
          <label for="cp_contact">Nomor ponsel narahubung: </label>
          <input type="text" class="form-control" name="cp_contact" id="cp_contact" placeholder="081234567890" value="{{ $letter->cp_contact ?? '' }}">
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
      </form>
    </div>
  </div>

  <div class="row my-4">
  </div>
@endsection

