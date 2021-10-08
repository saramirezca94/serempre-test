<?php

namespace App\Http\Controllers;

use App\Models\City;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cities = City::paginate(10);

        return view('city.index', compact('cities'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('city.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([

            'name' => 'required|max:255'

        ]);

        try {

            DB::beginTransaction();

            $city = new City();
            $city->name = $request->name;
            $city->save();

            DB::commit();

            return redirect(route('cities.index'))->with('message', ['success', __('The city was created')]);
            

        } catch (\Exception $th) {
            
            DB::rollback();

            return redirect(route('cities.index'))->with('message', ['danger', $th->getLine().' '.$th->getMessage()]);

        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\City  $city
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $city = City::whereId($id)->first();

        return view('city.edit', compact('city'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\City  $city
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([

            'name' => 'required|max:255',

        ]);

        try {

            DB::beginTransaction();

            $client = City::whereId($id)->first();
            $client->name = $request->name;
            $client->save();

            DB::commit();

            return redirect(route('cities.index'))->with('message', ['success', __('The city was updated')]);
            

        } catch (\Exception $th) {
            
            DB::rollback();

            return redirect(route('cities.index'))->with('message', ['danger', $th->getLine().' '.$th->getMessage()]);

        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\City  $city
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {

            $city = City::findorFail($id);

            $city->delete();

            return redirect(route('cities.index'))->with('message', ['success', __('The city was deleted')]);
            

        } catch (\Exception $th) {
            
            DB::rollback();

            return redirect(route('cities.index'))->with('message', ['danger', __('The city cannot be deleted')]);

        }
    }
}
