<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function intToRoman( $intOnDecimal ) {
        switch ( $intOnDecimal ) {
            case 1: return 'I';
            case 2: return 'II';
            case 3: return 'III';
            case 4: return 'IV';
            case 5: return 'V';
            case 6: return 'VI';
            case 7: return 'VII';
            case 8: return 'VIII';
            case 9: return 'IX';
            case 10: return 'X';
            case 11: return 'XI';
            case 12: return 'XII';
            default: return 'Unknown';
        }
    }

    public function intToMonth( $monthOnInt ) {
        switch ( $monthOnInt ) {
            case 1: return 'Januari';
            case 2: return 'Februari';
            case 3: return 'Maret';
            case 4: return 'April'; 
            case 5: return 'Mei';
            case 6: return 'Juni';
            case 7: return 'Juli';
            case 8: return 'Agustus';
            case 9: return 'September';
            case 10: return 'Oktober';
            case 11: return 'November';
            case 12: return 'Desember';
            default: return 'Unknown';
        }
    }

    public function intToDivision( $divisionInt ) {
        switch( $divisionInt ) {
            case 1: return 'Akpres';
            case 2: return 'Inovasi';
            case 3: return 'Medfo';
            case 4: return 'Pubrel';
        }
    }

    public function getLastLetterNumber() {
        $basicLastLetter = \App\BasicLetter::select()->orderBy('letter_ref_number', 'desc');
        $basicLastLetterNumber = 0;

        if ( $basicLastLetter->exists() ) {
            $basicLastLetter = $basicLastLetter->first();
            $basicLastLetterNumber = $basicLastLetter->letter_ref_number;
        }

        $internalInvLastLetter = \App\InternalInvitationLetter::select()->orderBy('letter_ref_number', 'desc');
        $internalInvLastLetterNumber = 0;

        if ( $internalInvLastLetter->exists() ) {
            $internalInvLastLetter = $internalInvLastLetter->first();
            $internalInvLastLetterNumber = $internalInvLastLetter->letter_ref_number;
        }
        
        $externalInvLastLetter = \App\ExternalInvitationLetter::select()->orderBy('letter_ref_number', 'desc');
        $externalInvLastLetterNumber = 0;

        if ( $externalInvLastLetter->exists() ) {
            $externalInvLastLetter = $externalInvLastLetter->first();
            $externalInvLastLetterNumber = $externalInvLastLetter->letter_ref_number;
        }

        return max( $basicLastLetterNumber, $internalInvLastLetterNumber, $externalInvLastLetterNumber );

    }
}
