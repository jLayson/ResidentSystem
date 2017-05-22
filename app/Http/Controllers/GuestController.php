<?php

namespace App\Http\Controllers;

use App\Guest;
use App\Resident;

use App\Http\Requests;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class GuestController extends Controller
{
	public function addGuestForm(){
		$residents = Resident::get();

		return view('adminguestform')->with('residents', $residents);
	}

	public function addGuestRecord(Request $request){
		$data = $request->input();
		unset($data['_token']);

		$guest = Guest::insert($data);

		return view('');
	}

	public function listGuestRecord($offset){
		$guests = Guest::offset($offset)
						->orderBy('created_at', 'desc')
						->limit(20)
						->get();

		$total = ceil(count($guests)/20);

		return view('')->with('guests', $guests)->with('total', $total);
	}

}