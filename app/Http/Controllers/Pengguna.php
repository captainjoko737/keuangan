<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Dashboard\Controllers;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class Pengguna extends Controller
{
    
    public function index() {
    	
    	$data['result'] = User::all();

    	$data['title'] = 'Pengguna';

    	return view('pengguna.index', $data);

    }

    public function create() {

    	$data['title'] = 'Tambah Pengguna';

    	return view('pengguna.add', $data);

    }

    public function store() {

    	$data['title'] = 'Tambah Pengguna';

       	request()->validate([
		    'name'          => 'required|string|max:255',
            'username'      => 'required|string|max:255|unique:users',
            'password'      => 'required|string|min:6|confirmed',
		]);


       	$user = User::create([
            'name' => request()->name,
            'username' => request()->username,
            'password' => Hash::make(request()->password),
        ]);

       	if ($user) {
       		session()->flash('status', 'User anda berhasil terdaftar, silahkan login!');
       	}else{
       		session()->flash('error', 'Maaf, terjadi kesalahan');
       	}
       	
       	return redirect()->route('pengguna');

    }

    public function edit() {

    	$data['title'] = 'Edit Pengguna';

    	$data['result'] = User::where('id', request()->id)->first();

    	return view('pengguna.edit', $data);
    	
    }

    public function save() {


    	if (request()->password) {

    		$user = User::where('id', request()->id)
			    		->update([
				    		'name' => request()->name,
				            'username' => request()->username,
				            'password' => Hash::make(request()->password),
				    	]);

    	}else{
    		$user = User::where('id', request()->id)
			    		->update([
				    		'name' => request()->name,
				            'username' => request()->username,
				    	]);
    	}

       	if ($user) {
       		session()->flash('status', 'User anda berhasil dirubah');
       	}else{
       		session()->flash('error', 'Maaf, terjadi kesalahan');
       	}
       	
       	return redirect()->route('pengguna');

    }

    public function drop(request $request) {

        $result = User::where('id', $request->id)->first();
        $result->delete();

        session()->flash('status', 'Pengguna berhasil dihapus!');
        return response()->json(['success'=>"", 'tr'=>'tr_'.$request->id]);
  
    }
}
