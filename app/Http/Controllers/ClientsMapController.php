<?php

namespace App\Http\Controllers;

use App\Imports\ClientImport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ClientsMapController extends Controller
{
    public function upload()
    {
        return view('import_clients');
    }

    public function index(Request $request)
    {

        $file = 'excel/client'.$request->file('file')->hashName();
        $filePath = $request->file('file')->storeAs('public', $file);

        $data = Excel::toArray(new ClientImport, $filePath);
        foreach ($data[0] as $row) {
            // Extract latitude and longitude from the "Lat/Lng" column
            $latLngString = (string) $row[3];
            $latLng = explode(',', $latLngString);
            $lat = $latLng[0];
            $lng = $latLng[1];

            // Add client to $clients array
            $clients[] = [
                'lat' => $lat,
                'lng' => $lng,
                'name' => $row[1] ?? '',
            ];
        }

        return view('clients_map', ['clients' => $clients]);

    }
}
