@extends('layouts.app')

@section('content')
    @if( !is_null($flash['status']) )
        <div class="row">
            <div class="col">
                <div class="alert alert-{{ $flash['status'] }}" role="alert">
                    {!! $flash['message'] !!}
                </div>
            </div>
        </div>
    @endif

    <div class="row">
        <div class="col">
            <h3>Surat-surat dasar.</h3>
             <hr>
        </div>
    </div>

    <div class="row">
        <div class="col">
            <table class="table table-sm table-striped">
                <thead class="thead-dark">
                  <tr>
                    <th scope="col">Nomor</th>
                    <th scope="col">File</th>
                    <th scope="col">Ttd Kadep</th>
                    <th scope="col">Aksi</th>
                  </tr>
                </thead>
                <tbody>
                    @foreach ($basicLetters as $l)
                        <tr>
                        <th scope="row">{{ $l->letter_ref_number }}</th>
                            <td>
                                @if( $l->acc_hod and $l->event_name != 'custom letter' )
                                    <a href="{{ url('storage\\' . $l->file_name) }}">{{ $l->file_name }}</a>
                                @else
                                    <span>{{ $l->file_name }}</span>
                                @endif
                            </td>
                            <td>
                                @if( $l->acc_hod )
                                    <span class="badge badge-secondary">Signed</span>
                                @else
                                    <a href="{{ url('sign/1/' . $l->id ) }}" class="badge badge-primary">Tanda Tangan</a>
                                @endif
                                
                            </td>
                            <td>
                                <a href="{{ url('basic/edit/' . $l->id ) }}" class="badge badge-info">Edit</a>
                                <a href="{{ url('basic/delete/' . $l->id ) }}" class="badge badge-danger">Hapus</a>
                            </td>
                        </tr> 
                    @endforeach
                </tbody>
              </table>
        </div>
    </div>

    <div class="row">
        <div class="col">
            <a href="{{ url('basic/create') }}" type="button" class="btn btn-success">Buat Surat Dasar</a>
            <a href="{{ url('basic/custom') }}" type="button" class="btn btn-secondary">Buat Surat Custom</a>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col">
            <h3>Surat permohonan pengisi acara dosen ke Rektorat.</h3>
             <hr>
        </div>
    </div>

    <div class="row">
        <div class="col">
            <table class="table table-sm table-striped">
                <thead class="thead-dark">
                  <tr>
                    <th scope="col">Nomor</th>
                    <th scope="col">File</th>
                    <th scope="col">Ttd Kadep</th>
                    <th scope="col">Aksi</th>
                  </tr>
                </thead>
                <tbody>
                    @foreach ($internalInvitationLetters as $l)
                        <tr>
                        <th scope="row">{{ $l->letter_ref_number }}</th>
                            <td>
                                @if( $l->acc_hod and $l->event_name != 'custom letter' )
                                    <a href="{{ url('storage\\' . $l->file_name) }}">{{ $l->file_name }}</a>
                                @else
                                    <span>{{ $l->file_name }}</span>
                                @endif
                            </td>
                            <td>
                                @if( $l->acc_hod )
                                    <span class="badge badge-secondary">Signed</span>
                                @else
                                    <a href="{{ url('sign/2/' . $l->id ) }}" class="badge badge-primary">Tanda Tangan</a>
                                @endif
                            </td>
                            <td>
                                <a href="{{ url('invitation/internal/edit/' . $l->id ) }}" class="badge badge-info">Edit</a>
                                <a href="{{ url('invitation/internal/delete/' . $l->id ) }}" class="badge badge-danger">Hapus</a>
                            </td>
                        </tr> 
                    @endforeach
                </tbody>
              </table>
        </div>
    </div>

    <div class="row">
        <div class="col">
            <a href="{{ url('invitation/internal/create' ) }}" type="button" class="btn btn-success">Buat Surat Permohonan Pemateri/Pembicara</a>
            <a href="{{ url('invitation/internal/custom') }}" type="button" class="btn btn-secondary">Buat Surat Custom</a>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col">
            <h3>Surat Undangan.</h3>
             <hr>
        </div>
    </div>

    <div class="row">
        <div class="col">
            <table class="table table-sm table-striped">
                <thead class="thead-dark">
                  <tr>
                    <th scope="col">Nomor</th>
                    <th scope="col">File</th>
                    <th scope="col">Ttd Kadep</th>
                    <th scope="col">Aksi</th>
                  </tr>
                </thead>
                <tbody>
                    @foreach ($externalInvitationLetters as $l)
                        <tr>
                        <th scope="row">{{ $l->letter_ref_number }}</th>
                            <td>
                                @if( $l->acc_hod and $l->event_name != 'custom letter' )
                                    <a href="{{ url('storage\\' . $l->file_name) }}">{{ $l->file_name }}</a>
                                @else
                                    <span>{{ $l->file_name }}</span>
                                @endif
                            </td>
                            <td>
                                @if( $l->acc_hod )
                                    <span class="badge badge-secondary">Signed</span>
                                @else
                                    <a href="{{ url('sign/3/' . $l->id ) }}" class="badge badge-primary">Tanda Tangan</a>
                                @endif
                            </td>
                            <td>
                                <a href="{{ url('invitation/external/edit/' . $l->id ) }}" class="badge badge-info">Edit</a>
                                <a href="{{ url('invitation/external/delete/' . $l->id ) }}" class="badge badge-danger">Hapus</a>
                            </td>
                        </tr> 
                    @endforeach
                </tbody>
              </table>
        </div>
    </div>

    <div class="row">
        <div class="col">
            <a href="{{ url('invitation/external/create' ) }}" type="button" class="btn btn-success">Buat Surat Undangan</a>
            <a href="{{ url('invitation/external/custom') }}" type="button" class="btn btn-secondary">Buat Surat Custom</a>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col">
            <h3>Surat lainnya.</h3>
             <hr>
        </div>
    </div>

    <div class="row">
        <div class="col">
            <table class="table table-sm table-striped">
                <thead class="thead-dark">
                  <tr>
                    <th scope="col">Nomor</th>
                    <th scope="col">File</th>
                    <th scope="col">Ttd Kadep</th>
                    <th scope="col">Aksi</th>
                  </tr>
                </thead>
                <tbody>
                    @foreach ($otherLetters as $l)
                        <tr>
                        <th scope="row">{{ $l->letter_ref_number }}</th>
                            <td>
                                <span>{{ $l->file_name }}</span>
                            </td>
                            <td>
                                @if( $l->acc_hod )
                                    <span class="badge badge-secondary">Signed</span>
                                @else
                                    <a href="{{ url('sign/4/' . $l->id ) }}" class="badge badge-primary">Tanda Tangan</a>
                                @endif
                            </td>
                            <td>
                                <a href="{{ url('other/edit/' . $l->id ) }}" class="badge badge-info">Edit</a>
                                <a href="{{ url('other/delete/' . $l->id ) }}" class="badge badge-danger">Hapus</a>
                            </td>
                        </tr> 
                    @endforeach
                </tbody>
              </table>
        </div>
    </div>

    <div class="row">
        <div class="col">
            <a href="{{ url('other/create' ) }}" type="button" class="btn btn-success">Buat Surat Lainnya</a>
            <a href="{{ url('other/custom') }}" type="button" class="btn btn-secondary">Buat Surat Custom</a>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col">
            <h3>Pintasan tautan.</h3>
             <hr>
        </div>
    </div>

    <div class="row mt-2">
        <div class="col">
            <a href="https://docs.google.com/spreadsheets/d/1njAAkYRgGcklkAR04xqPWhhrawslfsrvsYkfftDi5TM/edit?usp=sharing" target="_blank" type="button" class="btn btn-info">Lihat Spreadsheet Progress</a>
            <a href="https://drive.google.com/drive/folders/1r3xc25Lgp8fwz62KjcBz0ES7P-SUSkwW?usp=sharing" target="_blank" type="button" class="btn btn-info">Lihat Surat Selesai</a>
            <a href="https://drive.google.com/drive/folders/1mBX-F5pjkR8CJ_cP1PZkzUBMbjtvq0nc?usp=sharing" target="_blank" type="button" class="btn btn-info">Lihat Siat Didanai</a>
            <a href="https://drive.google.com/drive/folders/1q-iuhEJOv7ZLwQHoDOpGfWecqlu_v2Lc?usp=sharing" target="_blank" type="button" class="btn btn-info">Lihat Format Surat Word</a>
            <a href="https://drive.google.com/drive/folders/10AVSCqlEsNclTzoz8pY9Ja5y__g84U1g?usp=sharing" target="_blank" type="button" class="btn btn-info">Lihat Folder Progress Report</a>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col">
            <h3>Indeks.</h3>
             <hr>
        </div>
    </div>

    <div class="row">
        <div class="col">
            <table class="table table-sm table-striped">
                <thead class="thead-dark">
                  <tr>
                    <th scope="col">Singkatan</th>
                    <th scope="col">Keterangan</th>
                  </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>SIK</td>
                        <td>Permohonan Surat Izin Kegiatan</td>
                    </tr> 

                    <tr>
                        <td>SPDR</td>
                        <td>Permohonan Dana ke Rektorat</td>
                    </tr> 

                    <tr>
                        <td>STP</td>
                        <td>Permohonan Surat Tugas Panitia</td>
                    </tr>

                    <tr>
                        <td>SPM</td>
                        <td>Permohonan Surat Tugas Pemateri atau Pembicara Pegawai Unpad</td>
                    </tr> 

                    <tr>
                        <td>UPL</td>
                        <td>Undangan Pemateri Luar</td>
                    </tr> 

                    <tr>
                        <td>UM</td>
                        <td>Undangan Mahasiswa</td>
                    </tr> 

                    <tr>
                        <td>UD</td>
                        <td>Undangan Dosen</td>
                    </tr> 
                </tbody>
              </table>
        </div>
    </div>
@endsection