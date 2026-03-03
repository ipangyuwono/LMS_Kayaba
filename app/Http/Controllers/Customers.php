<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class Customers extends Controller
{
    public function index()
    {
        $Customers = Customer::orderBy('id')->get();
        return view('customers.index', compact('Customers'));
    }

    public function store(Request $request){
        $request->validate([
            'nama' => 'required',
            'kelas' => 'required',
            'departemen' => 'required',
            'password' => 'required',
        ]);

        Customer::create([
            'nama' => $request->nama,
            'kelas' => $request->kelas,
            'departemen' => $request->departemen,
            'password' => $request->password,
        ]);
        
        return redirect()->route('customers.index')->with('success', 'Customer berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $customer = Customer::findOrFail($id);
        $data = [
            'nama' => $request->nama,
            'kelas' => $request->kelas,
            'departemen' => $request->departemen,
        ];

        if ($request->filled('password')) {
            $data['password'] = $request->password;
        }

        $customer->update($data);
        return redirect()->route('customers.index')->with('success', 'Customer berhasil diupdate!');
    }


    public function delete(Customer $customer)
    {
        $customer -> delete();
        return redirect() -> route('customers.index');
    }

}

