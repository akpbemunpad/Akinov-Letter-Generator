<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use App\BasicLetter;

class BasicLetterController extends Controller
{
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('request.create.basic', [ 'job' => 'create' ]);
    }

    public function createCustom()
    {
        return view('request.create.custom', [ 'letterType' => 'basic' ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate( $request, [
            'division' => 'required|integer|gte:1|lte:4',
            'event_name' => 'required|max:200',
            'event_description' => 'required|max:300',
            'event_date' => 'required|max:100',
            'event_time' => 'required|max:100',
            'event_place' => 'required|max:100',
            'event_name' => 'required|max:100',
            'cp_name' => 'required|max:100',
            'cp_contact' => 'required|gte:0800000000',
        ]);

        $lastLetterNumber = $this->getLastLetterNumber();

        $basicSeasonings = ['SIK', 'SPDR', 'STP-' . $this->intToDivision( $request->division ) ];

        foreach ( $basicSeasonings as $bs ) {
            $lastLetterNumber++;
            $fileLetterNumber = '';

            if ( $lastLetterNumber < 10 )
                $fileLetterNumber = '00' . $lastLetterNumber;
            elseif ( $lastLetterNumber >=10 and $lastLetterNumber < 100 )
                $fileLetterNumber = '0' . $lastLetterNumber;
            elseif ( $lastLetterNumber >= 100 )
                $fileLetterNumber = $lastLetterNumber;

            $fileName = $fileLetterNumber . '. ' . $request->event_name . ' - (A-d) ' . explode('-', $bs)[0] . '.docx';

            $letter = new BasicLetter;
            $letter->division = $request->division;
            $letter->letter_ref_number = $lastLetterNumber;
            $letter->letter_type = $bs;
            $letter->event_name = $request->event_name;
            $letter->event_description = $request->event_description;
            $letter->event_date = $request->event_date;
            $letter->event_time = $request->event_time;
            $letter->event_place = $request->event_place;
            $letter->cp_name = $request->cp_name;
            $letter->cp_contact = $request->cp_contact;
            $letter->file_name = $fileName;
            $letter->save();

            $templateProcessor = new \PhpOffice\PhpWord\TemplateProcessor(storage_path('app/format/' . $bs . '.docx' ));

            $templateProcessor->setValue('letterRefNumber', $fileLetterNumber);
            $templateProcessor->setValue('letterMonth', $this->intToRoman(date('m')));
            $templateProcessor->setValue('letterFulldate', date('d') . ' ' . $this->intToMonth(date('m')) . ' ' . date('Y'));
            $templateProcessor->setValue('eventName', $request->event_name);
            $templateProcessor->setValue('eventDescription', $request->event_description);
            $templateProcessor->setValue('eventDate', $request->event_date);
            $templateProcessor->setValue('eventTime', $request->event_time);
            $templateProcessor->setValue('eventPlace', $request->event_place);
            $templateProcessor->setValue('cpName', $request->cp_name);
            $templateProcessor->setValue('cpContact', $request->cp_contact);
            
            $templateProcessor->saveAs(storage_path('app/public/' . $fileName));
        }

        $request->session()->flash('status', 'success');
        $request->session()->flash('message', 'Surat <b>' . $fileName . '</b> telah berhasil disimpan!' );
        
        return redirect('/');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeCustom(Request $request)
    {
        $this->validate( $request, [
            'letter_ref_number' => 'required|integer|unique:basic_letters,letter_ref_number|unique:internal_invitation_letters,letter_ref_number|unique:external_invitation_letters,letter_ref_number|unique:other_letters,letter_ref_number',
            'file_name' => 'required|max:100'
        ]);

        $letter = new BasicLetter;
        $letter->division = 0;
        $letter->letter_ref_number = $request->letter_ref_number;
        $letter->file_name = $request->file_name;
        $letter->letter_type = 'custom letter';
        $letter->event_name = 'custom letter';
        $letter->event_description = 'custom letter';
        $letter->event_date = 'custom letter';
        $letter->event_time = 'custom letter';
        $letter->event_place = 'custom letter';
        $letter->cp_name = 'custom letter';
        $letter->cp_contact = 'custom letter';
        $letter->save();

        $request->session()->flash('status', 'success');
        $request->session()->flash('message', 'Surat <b>' . $letter->file_name . '</b> telah berhasil dibuat!' );

        return redirect('/');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $letter = BasicLetter::find( $id );
        return view('request.create.basic', [
            'job' => 'edit',
            'letter' => $letter
            ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $this->validate( $request, [
            'id' => 'required|integer|gte:0',
            'division' => 'required|integer|gte:1|lte:4',
            'event_name' => 'required|max:200',
            'event_description' => 'required|max:300',
            'event_date' => 'required|max:100',
            'event_time' => 'required|max:100',
            'event_place' => 'required|max:100',
            'event_name' => 'required|max:100',
            'cp_name' => 'required|max:100',
            'cp_contact' => 'required|gte:0800000000',
        ]);

        $letter = BasicLetter::find( $request->id );

        $basicSeasonings = ['SIK', 'SPDR', 'STP-' . $this->intToDivision( $request->division ) ];

        $fileLetterNumber = '';

        if ( $letter->letter_ref_number < 10 )
            $fileLetterNumber = '00' . $letter->letter_ref_number;
        elseif ( $letter->letter_ref_number >=10 and $letter->letter_ref_number < 100 )
            $fileLetterNumber = '0' . $letter->letter_ref_number;
        elseif ( $letter->letter_ref_number >= 100 )
            $fileLetterNumber = $letter->letter_ref_number;

        $fileName = $fileLetterNumber . '. ' . $request->event_name . ' - (A-d) ' . explode('-', $letter->letter_type)[0] . '.docx';

        Storage::delete('public/' . $letter->file_name);
        
        $letter->division = $request->division;
        $letter->letter_type = $basicSeasonings[ $request->division - 1];
        $letter->event_name = $request->event_name;
        $letter->event_description = $request->event_description;
        $letter->event_date = $request->event_date;
        $letter->event_time = $request->event_time;
        $letter->event_place = $request->event_place;
        $letter->cp_name = $request->cp_name;
        $letter->cp_contact = $request->cp_contact;
        $letter->file_name = $fileName;
        $letter->save();

        $templateProcessor = new \PhpOffice\PhpWord\TemplateProcessor(storage_path('app/format/' . $letter->letter_type . '.docx' ));

        $templateProcessor->setValue('letterRefNumber', $fileLetterNumber);
        $templateProcessor->setValue('letterMonth', $this->intToRoman(date('m')));
        $templateProcessor->setValue('letterFulldate', date('d') . ' ' . $this->intToMonth(date('m')) . ' ' . date('Y'));
        $templateProcessor->setValue('eventName', $request->event_name);
        $templateProcessor->setValue('eventDescription', $request->event_description);
        $templateProcessor->setValue('eventDate', $request->event_date);
        $templateProcessor->setValue('eventTime', $request->event_time);
        $templateProcessor->setValue('eventPlace', $request->event_place);
        $templateProcessor->setValue('cpName', $request->cp_name);
        $templateProcessor->setValue('cpContact', $request->cp_contact);
        
        $templateProcessor->saveAs(storage_path('app/public/' . $fileName));

        $request->session()->flash('status', 'success');
        $request->session()->flash('message', 'Surat <b>' . $fileName . '</b> telah berhasil disunting!' );

        return redirect('/');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        $letter = BasicLetter::find($id);
        return view('request.delete', [
            'letter' => $letter,
            'letterType' => 'basic'
            ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function destroy( Request $request )
    {
        $fileName = '';
        if ( BasicLetter::where( 'id', $request->letterId )->exists() ) {
            $letter = BasicLetter::find( $request->letterId );
            $fileName = $letter->file_name;
            Storage::delete('public/' . $letter->file_name);
            $letter->delete();
        }

        $request->session()->flash('status', 'success');
        $request->session()->flash('message', 'Surat <b>' . $fileName . '</b> telah berhasil dihapus!' );

        return redirect('/');
    }
}
