<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\InternalInvitationLetter;
use App\ExternalInvitationLetter;

class InvitationLetterController extends Controller
{
    public function createInternal() {
        return view('request.create.invitation.internal', [ 'job' => 'create' ]);
    }

    public function createExternal() {
        return view('request.create.invitation.external', [ 'job' => 'create' ]);
    }

    public function createCustomInternal()
    {
        return view('request.create.custom', [ 'letterType' => 'invitation/internal' ]);
    }

    public function createCustomExternal()
    {
        return view('request.create.custom', [ 'letterType' => 'invitation/external' ]);
    }

    public function storeInternal( Request $request ) {
        $this->validate( $request, [
            'event_name' => 'required|max:200',
            'event_date' => 'required|max:100',
            'event_time' => 'required|max:100',
            'event_place' => 'required|max:100',
            'event_name' => 'required|max:100',
            'speaker_fullname' => 'required|max:100',
            'speaker_position' => 'required|max:100',
            'speaker_topic' => 'required|max:100',
            'cp_name' => 'required|max:100',
            'cp_contact' => 'required|gte:0800000000',
        ]);

        $lastLetterNumber = $this->getLastLetterNumber();;

        $lastLetterNumber++;
        $fileLetterNumber = '';

        if ( $lastLetterNumber < 10 )
            $fileLetterNumber = '00' . $lastLetterNumber;
        elseif ( $lastLetterNumber >=10 and $lastLetterNumber < 100 )
            $fileLetterNumber = '0' . $lastLetterNumber;
        elseif ( $lastLetterNumber >= 100 )
            $fileLetterNumber = $lastLetterNumber;

        $shortName = '';
        for( $i=0; $i<2; $i++ ) {
            $shortName = $shortName .  explode(' ', $request->speaker_fullname)[$i] . ' ';
        }

        $shortName = trim($shortName);

        $fileName = $fileLetterNumber . '. ' . $request->event_name . ' - (A-d) SPM ' . $shortName . '.docx';

        $letter = new InternalInvitationLetter;
        $letter->letter_ref_number = $lastLetterNumber;
        $letter->event_name = $request->event_name;
        $letter->event_date = $request->event_date;
        $letter->event_time = $request->event_time;
        $letter->event_place = $request->event_place;
        $letter->speaker_fullname = $request->speaker_fullname;
        $letter->speaker_position = $request->speaker_position;
        $letter->speaker_topic = $request->speaker_topic;
        $letter->cp_name = $request->cp_name;
        $letter->cp_contact = $request->cp_contact;
        $letter->file_name = $fileName;
        $letter->save();

        $templateProcessor = new \PhpOffice\PhpWord\TemplateProcessor(storage_path('app/format/SPM.docx' ));

        $templateProcessor->setValue('letterRefNumber', $fileLetterNumber);
        $templateProcessor->setValue('letterMonth', $this->intToRoman(date('m')));
        $templateProcessor->setValue('letterFulldate', date('d') . ' ' . $this->intToMonth(date('m')) . ' ' . date('Y'));
        $templateProcessor->setValue('eventName', $request->event_name);
        $templateProcessor->setValue('eventDescription', $request->event_description);
        $templateProcessor->setValue('eventDate', $request->event_date);
        $templateProcessor->setValue('eventTime', $request->event_time);
        $templateProcessor->setValue('eventPlace', $request->event_place);
        $templateProcessor->setValue('speakerFullName', $request->speaker_fullname);
        $templateProcessor->setValue('speakerPosition', $request->speaker_position);
        $templateProcessor->setValue('speakerTopic', $request->speaker_topic);
        $templateProcessor->setValue('cpName', $request->cp_name);
        $templateProcessor->setValue('cpContact', $request->cp_contact);
        
        $templateProcessor->saveAs(storage_path('app/public/' . $fileName));

        $request->session()->flash('status', 'success');
        $request->session()->flash('message', 'Surat <b>' . $fileName . '</b> telah berhasil disimpan!' );

        return redirect('/');
    }

    public function storeExternal( Request $request ) {
        $this->validate( $request, [
            'event_name' => 'required|max:200',
            'event_date' => 'required|max:100',
            'event_time' => 'required|max:100',
            'event_place' => 'required|max:100',
            'event_topic' => 'required|max:100',
            'event_name' => 'required|max:100',
            'speaker_type' => 'required|integer|gte:1|lte:2',
            'speaker_fullname' => 'required|max:100',
            'speaker_position' => 'max:100',
            'speaker_gender' => 'required|max:20',
            'cp_name' => 'required|max:100',
            'cp_contact' => 'required|gte:0800000000',
        ]);

        $lastLetterNumber = $this->getLastLetterNumber();

        $lastLetterNumber++;
        $fileLetterNumber = '';

        if ( $lastLetterNumber < 10 )
            $fileLetterNumber = '00' . $lastLetterNumber;
        elseif ( $lastLetterNumber >=10 and $lastLetterNumber < 100 )
            $fileLetterNumber = '0' . $lastLetterNumber;
        elseif ( $lastLetterNumber >= 100 )
            $fileLetterNumber = $lastLetterNumber;

        $shortName = '';
        for( $i=0; $i<2; $i++ ) {
            $shortName = $shortName .  explode(' ', $request->speaker_fullname)[$i] . ' ';
        }

        $shortName = trim($shortName);

        $fileName = $fileLetterNumber . '. ' . $request->event_name . ' - (A-d) SPM ' . $shortName . '.docx';

        $letter = new ExternalInvitationLetter;
        $letter->letter_ref_number = $lastLetterNumber;
        $letter->event_name = $request->event_name;
        $letter->event_date = $request->event_date;
        $letter->event_time = $request->event_time;
        $letter->event_place = $request->event_place;
        $letter->event_topic = $request->event_topic;
        $letter->speaker_type = $request->speaker_type;
        $letter->speaker_fullname = $request->speaker_fullname;
        $letter->speaker_position = $request->speaker_position;
        $letter->speaker_gender = $request->speaker_gender;
        $letter->cp_name = $request->cp_name;
        $letter->cp_contact = $request->cp_contact;
        $letter->file_name = $fileName;
        $letter->save();

        $templateProcessor = '';

        if ( $request->speaker_type == 1 )
            $templateProcessor = new \PhpOffice\PhpWord\TemplateProcessor(storage_path('app/format/UPL-Bicara.docx' ));
        else
            $templateProcessor = new \PhpOffice\PhpWord\TemplateProcessor(storage_path('app/format/UPL-Materi.docx' ));

        $templateProcessor->setValue('letterRefNumber', $fileLetterNumber);
        $templateProcessor->setValue('letterMonth', $this->intToRoman(date('m')));
        $templateProcessor->setValue('letterFulldate', date('d') . ' ' . $this->intToMonth(date('m')) . ' ' . date('Y'));
        $templateProcessor->setValue('eventName', $request->event_name);
        $templateProcessor->setValue('eventDescription', $request->event_description);
        $templateProcessor->setValue('eventDate', $request->event_date);
        $templateProcessor->setValue('eventTime', $request->event_time);
        $templateProcessor->setValue('eventPlace', $request->event_place);
        $templateProcessor->setValue('eventTopic', $request->event_topic);
        $templateProcessor->setValue('speakerFullName', $request->speaker_fullname);
        $templateProcessor->setValue('speakerPosition', $request->speaker_position);
        $templateProcessor->setValue('speakerGender', $request->speaker_gender);
        $templateProcessor->setValue('cpName', $request->cp_name);
        $templateProcessor->setValue('cpContact', $request->cp_contact);
        
        $templateProcessor->saveAs(storage_path('app/public/' . $fileName));

        $request->session()->flash('status', 'success');
        $request->session()->flash('message', 'Surat <b>' . $fileName . '</b> telah berhasil disimpan!' );

        return redirect('/');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function deleteInternal($id)
    {
        $letter = InternalInvitationLetter::find($id);
        return view('request.delete', [
            'letter' => $letter,
            'letterType' => 'invitation/internal'
            ]);
    }

    
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function deleteExternal($id)
    {
        $letter = ExternalInvitationLetter::find($id);
        return view('request.delete', [
            'letter' => $letter,
            'letterType' => 'invitation/external'
            ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function destroyInternal( Request $request )
    {
        $fileName = '';
        if ( InternalInvitationLetter::where( 'id', $request->letterId )->exists() ) {
            $letter = InternalInvitationLetter::find( $request->letterId );
            $fileName = $letter->file_name;
            Storage::delete('public/' . $letter->file_name);
            $letter->delete();
        }
        
        $request->session()->flash('status', 'success');
        $request->session()->flash('message', 'Surat <b>' . $request->file_name . '</b> telah berhasil disimpan!' );

        return redirect('/');
    }

        /**
     * Remove the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function destroyExternal( Request $request )
    {
        $fileName = '';
        if ( ExternalInvitationLetter::where( 'id', $request->letterId )->exists() ) {
            $letter = ExternalInvitationLetter::find( $request->letterId );
            $fileName = $letter->file_name;
            Storage::delete('public/' . $letter->file_name);
            $letter->delete();
        }

        $request->session()->flash('status', 'success');
        $request->session()->flash('message', 'Surat <b>' . $request->file_name . '</b> telah berhasil disimpan!' );

        return redirect('/');
    }

    public function editInternal( $id ) {
        $letter = InternalInvitationLetter::find( $id );
        return view('request.create.invitation.internal', [
            'job' => 'edit',
            'letter' => $letter
            ]);
    }

    public function updateInternal( Request $request ) {
        $this->validate( $request, [
            'id' => 'required|integer|gte:0',
            'event_name' => 'required|max:200',
            'event_date' => 'required|max:100',
            'event_time' => 'required|max:100',
            'event_place' => 'required|max:100',
            'event_name' => 'required|max:100',
            'speaker_fullname' => 'required|max:100',
            'speaker_position' => 'required|max:100',
            'speaker_topic' => 'required|max:100',
            'cp_name' => 'required|max:100',
            'cp_contact' => 'required|gte:0800000000',
        ]);

        $letter = InternalInvitationLetter::find( $request->id );

        $fileLetterNumber = '';

        if ( $letter->letter_ref_number < 10 )
            $fileLetterNumber = '00' . $letter->letter_ref_number;
        elseif ( $letter->letter_ref_number >=10 and $letter->letter_ref_number < 100 )
            $fileLetterNumber = '0' . $letter->letter_ref_number;
        elseif ( $letter->letter_ref_number >= 100 )
            $fileLetterNumber = $letter->letter_ref_number;

        $shortName = '';
        for( $i=0; $i<2; $i++ ) {
            $shortName = $shortName .  explode(' ', $request->speaker_fullname)[$i] . ' ';
        }

        $shortName = trim($shortName);

        $fileName = $fileLetterNumber . '. ' . $request->event_name . ' - (A-d) SPM ' . $shortName . '.docx';

        Storage::delete('public/' . $letter->file_name);
        
        $letter->event_name = $request->event_name;
        $letter->event_date = $request->event_date;
        $letter->event_time = $request->event_time;
        $letter->event_place = $request->event_place;
        $letter->speaker_fullname = $request->speaker_fullname;
        $letter->speaker_position = $request->speaker_position;
        $letter->speaker_topic = $request->speaker_topic;
        $letter->cp_name = $request->cp_name;
        $letter->cp_contact = $request->cp_contact;
        $letter->file_name = $fileName;
        $letter->save();

        $templateProcessor = new \PhpOffice\PhpWord\TemplateProcessor(storage_path('app/format/SPM.docx' ));

        $templateProcessor->setValue('letterRefNumber', $fileLetterNumber);
        $templateProcessor->setValue('letterMonth', $this->intToRoman(date('m')));
        $templateProcessor->setValue('letterFulldate', date('d') . ' ' . $this->intToMonth(date('m')) . ' ' . date('Y'));
        $templateProcessor->setValue('eventName', $request->event_name);
        $templateProcessor->setValue('eventDescription', $request->event_description);
        $templateProcessor->setValue('eventDate', $request->event_date);
        $templateProcessor->setValue('eventTime', $request->event_time);
        $templateProcessor->setValue('eventPlace', $request->event_place);
        $templateProcessor->setValue('speakerFullName', $request->speaker_fullname);
        $templateProcessor->setValue('speakerPosition', $request->speaker_position);
        $templateProcessor->setValue('speakerTopic', $request->speaker_topic);
        $templateProcessor->setValue('cpName', $request->cp_name);
        $templateProcessor->setValue('cpContact', $request->cp_contact);
        
        $templateProcessor->saveAs(storage_path('app/public/' . $fileName));

        $request->session()->flash('status', 'success');
        $request->session()->flash('message', 'Surat <b>' . $fileName . '</b> telah berhasil disunting!' );

        return redirect('/');
    }

    public function editExternal( $id ) {
        $letter = ExternalInvitationLetter::find( $id );
        return view('request.create.invitation.external', [
            'job' => 'edit',
            'letter' => $letter
            ]);
    }

    public function updateExternal( Request $request ) {
        $this->validate( $request, [
            'id' => 'required|integer|gte:0',
            'event_name' => 'required|max:200',
            'event_date' => 'required|max:100',
            'event_time' => 'required|max:100',
            'event_place' => 'required|max:100',
            'event_topic' => 'required|max:100',
            'event_name' => 'required|max:100',
            'speaker_type' => 'required|integer|gte:1|lte:2',
            'speaker_fullname' => 'required|max:100',
            'speaker_position' => 'max:100',
            'speaker_gender' => 'required|max:20',
            'cp_name' => 'required|max:100',
            'cp_contact' => 'required|gte:0800000000',
        ]);

        $shortName = '';
        for( $i=0; $i<2; $i++ ) {
            $shortName = $shortName .  explode(' ', $request->speaker_fullname)[$i] . ' ';
        }

        $shortName = trim($shortName);

        $letter = ExternalInvitationLetter::find( $request->id );

        $fileLetterNumber = '';
        
        if ( $letter->letter_ref_number < 10 )
            $fileLetterNumber = '00' . $letter->letter_ref_number;
        elseif ( $letter->letter_ref_number >=10 and $letter->letter_ref_number < 100 )
            $fileLetterNumber = '0' . $letter->letter_ref_number;
        elseif ( $letter->letter_ref_number >= 100 )
            $fileLetterNumber = $letter->letter_ref_number;

        $fileName = $fileLetterNumber . '. ' . $request->event_name . ' - (A-d) SPM ' . $shortName . '.docx';


        Storage::delete('public/' . $letter->file_name);

        $letter->event_name = $request->event_name;
        $letter->event_date = $request->event_date;
        $letter->event_time = $request->event_time;
        $letter->event_place = $request->event_place;
        $letter->event_topic = $request->event_topic;
        $letter->speaker_type = $request->speaker_type;
        $letter->speaker_fullname = $request->speaker_fullname;
        $letter->speaker_position = $request->speaker_position;
        $letter->speaker_gender = $request->speaker_gender;
        $letter->cp_name = $request->cp_name;
        $letter->cp_contact = $request->cp_contact;
        $letter->file_name = $fileName;
        $letter->save();

        $templateProcessor = '';

        if ( $request->speaker_type == 1 )
            $templateProcessor = new \PhpOffice\PhpWord\TemplateProcessor(storage_path('app/format/UPL-Bicara.docx' ));
        else
            $templateProcessor = new \PhpOffice\PhpWord\TemplateProcessor(storage_path('app/format/UPL-Materi.docx' ));

        $templateProcessor->setValue('letterRefNumber', $fileLetterNumber);
        $templateProcessor->setValue('letterMonth', $this->intToRoman(date('m')));
        $templateProcessor->setValue('letterFulldate', date('d') . ' ' . $this->intToMonth(date('m')) . ' ' . date('Y'));
        $templateProcessor->setValue('eventName', $request->event_name);
        $templateProcessor->setValue('eventDescription', $request->event_description);
        $templateProcessor->setValue('eventDate', $request->event_date);
        $templateProcessor->setValue('eventTime', $request->event_time);
        $templateProcessor->setValue('eventPlace', $request->event_place);
        $templateProcessor->setValue('eventTopic', $request->event_topic);
        $templateProcessor->setValue('speakerFullName', $request->speaker_fullname);
        $templateProcessor->setValue('speakerPosition', $request->speaker_position);
        $templateProcessor->setValue('speakerGender', $request->speaker_gender);
        $templateProcessor->setValue('cpName', $request->cp_name);
        $templateProcessor->setValue('cpContact', $request->cp_contact);
        
        $templateProcessor->saveAs(storage_path('app/public/' . $fileName));

        $request->session()->flash('status', 'success');
        $request->session()->flash('message', 'Surat <b>' . $fileName . '</b> telah berhasil disunting!' );

        return redirect('/');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeCustomInternal(Request $request)
    {
        $this->validate( $request, [
            'letter_ref_number' => 'required|integer|unique:basic_letters,letter_ref_number|unique:internal_invitation_letters,letter_ref_number|unique:external_invitation_letters,letter_ref_number|unique:other_letters,letter_ref_number',
            'file_name' => 'required|max:100',
        ]);

        $letter = new InternalInvitationLetter;
        $letter->letter_ref_number = $request->letter_ref_number;
        $letter->file_name = $request->file_name;
        $letter->event_name = 'custom letter';
        $letter->event_date = 'custom letter';
        $letter->event_time = 'custom letter';
        $letter->event_place = 'custom letter';
        $letter->speaker_fullname = 'custom letter';
        $letter->speaker_position = 'custom letter';
        $letter->speaker_topic = 'custom letter';
        $letter->cp_name = 'custom letter';
        $letter->cp_contact = 'custom letter';
        $letter->save();

        $request->session()->flash('status', 'success');
        $request->session()->flash('message', 'Surat <b>' . $request->file_name . '</b> telah berhasil disimpan!' );

        return redirect('/');
    }

        /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeCustomExternal(Request $request)
    {
        $this->validate( $request, [
            'letter_ref_number' => 'required|integer|unique:basic_letters,letter_ref_number|unique:internal_invitation_letters,letter_ref_number|unique:external_invitation_letters,letter_ref_number|unique:other_letters,letter_ref_number',
            'file_name' => 'required|max:100',
        ]);

        $letter = new ExternalInvitationLetter;
        $letter->letter_ref_number = $request->letter_ref_number;
        $letter->file_name = $request->file_name;
        $letter->event_name = 'custom letter';
        $letter->event_date = 'custom letter';
        $letter->event_time = 'custom letter';
        $letter->event_place = 'custom letter';
        $letter->event_topic = 'custom letter';
        $letter->speaker_type = 0;
        $letter->speaker_fullname = 'custom letter';
        $letter->speaker_position = 'custom letter';
        $letter->speaker_gender = 'custom letter';
        $letter->cp_name = 'custom letter';
        $letter->cp_contact = 'custom letter';
        $letter->save();

        $request->session()->flash('status', 'success');
        $request->session()->flash('message', 'Surat <b>' . $request->file_name . '</b> telah berhasil disimpan!' );

        return redirect('/');
    }
}
