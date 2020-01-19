<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Guest;
use Auth;

class GuestsController extends Controller
{
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //$guests = Guest::latest()->get();
        $guests = Guest::orderBy('created_at', 'desc')->paginate(10);
        return view('guest')->with('guests', $guests);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view ('create');
    }

    public function add_new()
    { 
        if(Auth::guest()){
            return redirect('/guests')->with('error', 'Unauthorized page!');
        }
        return view ('add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'fullname' => 'required',
            'email' => 'required| email',
            'comment' => 'required'
        ]);

        $form_data = array(
            'fullname'        =>  $request->fullname,
            'email' => $request->email,
            'comment' => $request->comment
        );

        $saveData = Guest::create($form_data);

        return redirect('/guests')->with('success', 'Guest Registered'); 

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
        $guest = Guest::find($id);
        //Check for correct user
         /*if(auth()->user()->id !== $guest->user->id){
            return redirect('/posts')->with('error', 'Unauthorized page!');
        }*/

        return view('edit')->with('guest', $guest);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'fullname' => 'required',
            'email' => 'required| email',
            'comment' => 'required'
        ]);

        $form_data = array(
            'fullname'        =>  $request->fullname,
            'email' => $request->email,
            'comment' => $request->comment
        );

        $saveData = Guest::whereId($id)->update($form_data);

        return redirect('/guests')->with('success', 'Data Updated'); 
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $guest = Guest::find($id);
        $guest->delete();
        return redirect('/guests')->with('success', 'Guest data has been cleared');
    }
}
