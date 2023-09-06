<?php

namespace App\Http\Controllers;

use App\Http\Requests\ClientRequest;
use App\Models\Client;

class ClientController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function list(){
        $clients=Client::all();
        return response()->json([
            'status' => 'success',
            'clients' => $clients,
        ]);
    }

    public function add(ClientRequest $request){
        $client=new Client();
        $client->name=$request->input('name');
        $client->lastname=$request->input('lastname');
        $client->email=$request->input('email');
        $client->phone=$request->input('phone');
        $client->save();

        return response()->json([
            'status' => 'success',
            'client' => $client,
        ]);
    }
}
