<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Listing;

class ListingsController extends Controller
{

    public function __construct(){
        $this->middleware('auth',['except'=>['index','show']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $listing = Listing::orderBy('created_at','desc')->get();
        return view('listing')->with('listings',$listing);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('createListing');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       $this->validate($request,[
           'name' => 'required',
           'email' => 'email'
       ]);

       //Create Listing
$listing = new Listing;
$listing->name = $request->input('name');
$listing->website = $request->input('website');
$listing->email = $request->input('email');
$listing->phone = $request->input('phone');
$listing->address = $request->input('address');
$listing->bio = $request->input('bio');
$listing->user_id = auth()->user()->id;
$listing->save();

return redirect('/dashboard')->with('success','Listing Added');



    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
       $listing = Listing::find($id);
       return view('listdetail')->with('listing',$listing);
       
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $listing = Listing::find($id);

        return view('editListing')->with('listing',$listing);
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
        $this->validate($request,[
'name' => 'required',
'email' => 'email'
        ]);

        //Edit Listing
    $listing = Listing::find($id);
    $listing->name = $request->input('name');
$listing->website = $request->input('website');
$listing->email = $request->input('email');
$listing->phone = $request->input('phone');
$listing->address = $request->input('address');
$listing->bio = $request->input('bio');
$listing->user_id = auth()->user()->id;
$listing->save();
return redirect('/dashboard')->with('success','Listing Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $listing = Listing::find($id);
        $listing->delete();
        return redirect('/dashboard')->with('success','Listing Deleted');
    }
}
