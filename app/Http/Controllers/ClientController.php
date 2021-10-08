<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        return view('client.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $cities = City::paginate(20);
        
        return view('client.create', compact('cities'));

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

            'name' => 'required|max:255',
            'city' => 'required|max:255',

        ]);

        try {

            DB::beginTransaction();

            $client = new Client();
            $client->name = $request->name;
            $client->city_id = $request->city;
            $client->save();

            DB::commit();

            return redirect(route('clients.index'))->with('message', ['success', __('The client was created')]);
            

        } catch (\Exception $th) {
            
            DB::rollback();

            return redirect(route('clients.index'))->with('message', ['danger', $th->getLine().' '.$th->getMessage()]);

        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $cities = City::all();

        $client = Client::whereId($id)->first();

        return view('client.edit', compact('cities', 'client'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([

            'name' => 'required|max:255',
            'city' => 'required|max:255',

        ]);

        try {

            DB::beginTransaction();

            $client = Client::whereId($id)->first();
            $client->name = $request->name;
            $client->city_id = $request->city;
            $client->save();

            DB::commit();

            return redirect(route('clients.index'))->with('message', ['success', __('The client was updated')]);
            

        } catch (\Exception $th) {
            
            DB::rollback();

            return redirect(route('clients.index'))->with('message', ['danger', $th->getLine().' '.$th->getMessage()]);

        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $client = Client::findorFail($id);

        $client->delete();

        return redirect(route('clients.index'))->with('message', ['danger', __('The client was deleted')]);
    }
}
