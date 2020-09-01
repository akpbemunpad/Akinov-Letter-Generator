@extends('layouts.app')

@section('content')
  <div class="row">
    <div class="col-lg-5">
      @if( $job == 'create' )
        <h3>Buat surat undangan baru.</h3>
      @elseif ( $job == 'edit' )
        <h3>Sunting surat undangan baru.</h3>
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
      <form action="{{ url('/invitation/external/' . $job ) }}" method="post">
        @csrf
        <input type="hidden" name="id" value="{{ $letter->id ?? '' }}">
        <div class="form-group">
          <label for="event_name">Nama kegiatan: </label>
        <input type="text" class="form-control" name="event_name" id="event_name" placeholder="mis: Comblangin Inovasi" value="{{ $letter->event_name ?? '' }}">
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
            <label for="speaker_topic">Tema kegiatan: </label>
            <input type="text" class="form-control" name="event_topic" id="speaker_topic" placeholder="mis: Manajemen Keharmonisan Rumah Tangga dalam Revolusi Industri 4.0" value="{{ $letter->event_topic ?? '' }}">
            <small class="form-text text-muted">Singkat saja.</small>
        </div>

        <div class="form-group">
            <label>Jenis pengisi acara: </label>
            <div class="form-check">
                <input class="form-check-input" type="radio" id="pembicara" name="speaker_type" value="1" @if(isset($letter->speaker_type)) {{ $letter->speaker_type == 1 ? 'checked' : ''}} @endif>
                <label class="form-check-label" for="pembicara">
                Pembicara
                </label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" id="pemateri" name="speaker_type" value="2"  @if(isset($letter->speaker_type)) {{ $letter->speaker_type == 2 ? 'checked' : ''}} @endif>
                <label class="form-check-label" for="pemateri">
                Pemateri
                </label>
            </div>
        </div>

        <div class="form-group">
            <label for="speaker_fullname">Nama lengkap pengisi (beserta gelar): </label>
            <input type="text" class="form-control" name="speaker_fullname" id="speaker_fullname" placeholder="mis: Dr. Cukup Mulyana" value="{{ $letter->speaker_fullname ?? '' }}">
        </div>
        <div class="form-group">
            <label for="speaker_position">Jabatan pengisi: </label>
            <input type="text" class="form-control" name="speaker_position" id="speaker_position" placeholder="mis: Dosen Fakultas Mipa" value="{{ $letter->speaker_position ?? '' }}">
        </div>

        <div class="form-group">
            <label>Kata sapaan: </label>
            <div class="form-check">
                <input class="form-check-input" type="radio" id="bapak" name="speaker_gender" value="Bapak" @if(isset($letter->speaker_gender)) {{ $letter->speaker_gender == 'Bapak' ? 'checked' : ''}} @endif>
                <label class="form-check-label" for="bapak">
                Bapak
                </label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" id="ibu" name="speaker_gender" value="Ibu" @if(isset($letter->speaker_gender)) {{ $letter->speaker_gender == 'Ibu' ? 'checked' : ''}} @endif>
                <label class="form-check-label" for="ibu">
                Ibu
                </label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" id="saudara" name="speaker_gender" value="Saudara" @if(isset($letter->speaker_gender)) {{ $letter->speaker_gender == 'Saudara' ? 'checked' : ''}} @endif>
                <label class="form-check-label" for="saudara">
                Saudara
                </label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" id="saudari" name="speaker_gender" value="Saudari" @if(isset($letter->speaker_gender)) {{ $letter->speaker_gender == 'Saudari' ? 'checked' : ''}} @endif>
                <label class="form-check-label" for="saudari">
                Saudari
                </label>
            </div>
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

