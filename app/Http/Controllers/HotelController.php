<?php

namespace App\Http\Controllers;

use App\Models\Hotel;
use Illuminate\Http\Request;

class HotelController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('upload-json');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreHotelRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:json',
        ]);

        $fileName = time().'.'.$request->file->extension();
        $request->file->move(public_path('uploads'), $fileName);
        $path = public_path('uploads/').$fileName;
        $json = json_decode(file_get_contents($path));

        foreach ($json->listed as $value)
        {
            $hotel = new Hotel();
            $hotel->business_name = $value->business_name;
            $hotel->image = $value->image;
            $hotel->rating = $value->rating;
            $hotel->address = $value->address;
            $hotel->description = $value->description;

            if (sizeof($value->restaurant_type) != 0)
            {
                $hotel->restaurant_type = json_encode($value->restaurant_type);
            }
            else
            {
                $hotel->restaurant_type = null;
            }

            if (sizeof($value->time_available) != 0) {
                $hotel->time_available = json_encode($value->time_available);
            }
            else
            {
                $hotel->time_available = null;
            }
            $hotel->seat_available = $value->seat_available;
            $hotel->get_time = $value->get_time;
            $hotel->service_provider = $value->service_provider;
            $hotel->price = $value->price;
            $hotel->save();
//            return "hello";
        }
        return back()->with('success','You have successfully upload file.')->with('file',$fileName);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Hotel  $hotel
     * @return \Illuminate\Http\Response
     */
    public function show(Hotel $hotel)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Hotel  $hotel
     * @return \Illuminate\Http\Response
     */
    public function edit(Hotel $hotel)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateHotelRequest  $request
     * @param  \App\Models\Hotel  $hotel
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateHotelRequest $request, Hotel $hotel)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Hotel  $hotel
     * @return \Illuminate\Http\Response
     */
    public function destroy(Hotel $hotel)
    {
        //
    }
}
