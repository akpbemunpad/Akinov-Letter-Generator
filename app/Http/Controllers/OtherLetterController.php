<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\OtherLetter;

class OtherLetterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('request.create.other', [
            'job' => 'create'
        ]);
    }

    public function createCustom()
    {
        return view('request.create.custom', [ 'letterType' => 'other' ]);
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
            'file_name' => 'required|max:100'
        ]);

        $lastLetterNumber = $this->getLastLetterNumber();
        $lastLetterNumber++;

        $letter = new OtherLetter;
        $letter->letter_ref_number = $lastLetterNumber;
        $letter->file_name = $request->file_name;
        $letter->save();

        $request->session()->flash('status', 'success');
        $request->session()->flash('message', 'Surat <b>' . $letter->file_name . '</b> telah berhasil dibuat!' );

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

        $letter = new OtherLetter;
        $letter->letter_ref_number = $request->letter_ref_number;
        $letter->file_name = $request->file_name;
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
        $letter = OtherLetter::find($id);
        return view('request.create.other', [
            'letterType' => 'other',
            'letter' => $letter,
            'job' => 'edit'
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $this->validate( $request, [
            'id' => 'required|integer|gte:0',
            'file_name' => 'required|max:100'
        ]);

        $letter = OtherLetter::find( $request->id );
        $letter->file_name = $request->file_name;
        $letter->save();

        $request->session()->flash('status', 'success');
        $request->session()->flash('message', 'Surat <b>' . $letter->file_name . '</b> telah berhasil disunting!' );

        return redirect('/');
    }

    public function delete($id) {
        $letter = OtherLetter::find($id);
        return view('request.delete', [
            'letterType' => 'other',
            'letter' => $letter
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $letter = OtherLetter::find( $request->letterId );
        $letter->delete();

        $request->session()->flash('status', 'success');
        $request->session()->flash('message', 'Surat <b>' . $letter->file_name . '</b> telah berhasil dihapus!' );

        return redirect('/');
    }
}
