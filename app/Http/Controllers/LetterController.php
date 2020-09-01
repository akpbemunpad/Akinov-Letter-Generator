<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\InternalInvitationLetter;
use App\ExternalInvitationLetter;
use App\BasicLetter;
use App\OtherLetter;

class LetterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index( Request $request )
    {
        $basicLetter = BasicLetter::select()->orderBy('letter_ref_number', 'asc')->get();
        $internalInvLetter = InternalInvitationLetter::select()->orderBy('letter_ref_number', 'asc')->get();
        $externalInvLetter = ExternalInvitationLetter::select()->orderBy('letter_ref_number', 'asc')->get();
        $otherLetter = OtherLetter::select()->orderBy('letter_ref_number', 'asc')->get();
        
        return view('request.index', [
            'basicLetters' => $basicLetter,
            'internalInvitationLetters' => $internalInvLetter,
            'externalInvitationLetters' => $externalInvLetter,
            'otherLetters' => $otherLetter,
            'flash' => [ 
                'status' => $request->session()->get('status'),
                'message' => $request->session()->get('message')
                ]
            ]);
    }

    public function hodValidation( $letterType, $id ) {
        $letter = '';
        $letterTypeText = '';
        $preview = true;

        switch ( $letterType ) {
            case 1:
                $letter = BasicLetter::where( 'id', $id );
                if ( $letter->exists() ) {
                    $letter = $letter->first();
                    if ( $letter->event_name == 'custom letter' )
                        $preview = false;
                }
                $letterTypeText = 'basic';
            break;

            case 2:
                $letter = InternalInvitationLetter::where( 'id', $id );
                if ( $letter->exists() ) {
                    $letter = $letter->first();
                    if ( $letter->event_name == 'custom letter' )
                        $preview = false;
                }
                $letterTypeText = 'invitation/internal';
            break;

            case 3:
                $letter = ExternalInvitationLetter::where( 'id', $id );
                if ( $letter->exists() ) {
                    $letter = $letter->first();
                    if ( $letter->event_name == 'custom letter' )
                        $preview = false;
                }
                $letterTypeText = 'invitation/external';
            break;

            case 4:
                $letter = OtherLetter::where( 'id', $id );
                if ( $letter->exists() ) 
                    $letter = $letter->first();
                $letterTypeText = 'other';
                $preview = false;
            break;
        }
            
        return view ('request.sign', [
            'letter' => $letter,
            'letterType' => $letterTypeText,
            'preview' => $preview
            ]);
    }

    public function basicSign( Request $request ) {
        $letter = BasicLetter::where( 'id', $request->letter_id);
        if ( $letter->doesntExist() ) {
            return redirect( '/' );
        }

        $letter = $letter->first();
        $letter->acc_hod = true;
        $letter->save();

        $request->session()->flash('status', 'success');
        $request->session()->flash('message', 'Surat <b>' . $letter->file_name . '</b> telah berhasil ditandatangani!' );

        return redirect('/');
    }

    public function internalInvSign( Request $request ) {
        $letter = InternalInvitationLetter::where( 'id', $request->letter_id);
        if ( $letter->doesntExist() ) {
            return redirect( '/' );
        }

        $letter = $letter->first();
        $letter->acc_hod = true;
        $letter->save();

        $request->session()->flash('status', 'success');
        $request->session()->flash('message', 'Surat <b>' . $letter->file_name . '</b> telah berhasil ditandatangani!' );

        return redirect('/');
    }

    public function externalInvSign( Request $request ) {
        $letter = ExternalInvitationLetter::where( 'id', $request->letter_id);
        if ( $letter->doesntExist() ) {
            return redirect( '/' );
        }

        $letter = $letter->first();
        $letter->acc_hod = true;
        $letter->save();

        $request->session()->flash('status', 'success');
        $request->session()->flash('message', 'Surat <b>' . $letter->file_name . '</b> telah berhasil ditandatangani!' );

        return redirect('/');
    }

    public function otherSign( Request $request ) {
        $letter = OtherLetter::where( 'id', $request->letter_id);
        if ( $letter->doesntExist() ) {
            return redirect( '/' );
        }

        $letter = $letter->first();
        $letter->acc_hod = true;
        $letter->save();
        
        $request->session()->flash('status', 'success');
        $request->session()->flash('message', 'Surat <b>' . $letter->file_name . '</b> telah berhasil ditandatangani!' );

        return redirect('/');
    }
}
