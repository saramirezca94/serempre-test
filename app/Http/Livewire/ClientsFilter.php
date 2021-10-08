<?php

namespace App\Http\Livewire;

use App\Models\City;
use App\Models\Client;
use Livewire\Component;

class ClientsFilter extends Component
{
    public $city_id = '';

    public function render()
    {
        $query = Client::query();

        if($this->city_id != ''){

            $query->where('city_id', $this->city_id);
            
        }
        return view('livewire.clients-filter', [
            'clients' => $query->with('city')->paginate(10),
            'cities' => City::all()
        ]);
    }
}
