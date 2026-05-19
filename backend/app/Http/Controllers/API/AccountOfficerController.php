<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\AccountOfficer;
use App\Models\User;
use Illuminate\Http\Request;

class AccountOfficerController extends Controller
{
    // GET all AO
    public function index()
    {
        $aos = AccountOfficer::orderBy('created_at', 'desc')->get();

        return response()->json([
            'message' => 'Data AO berhasil diambil',
            'data'    => $aos,
            'total'   => $aos->count()
        ]);
    }

    // POST create new AO
    public function store(Request $request)
    {
        $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'username'     => 'required|string|unique:account_officers|unique:users|max:100',
            'no_hp'        => 'required|string|min:10|max:13',
            'wilayah'      => 'required|string',
            'password'     => 'required|min:8'
        ]);

        $ao = AccountOfficer::create([
            'nama_lengkap' => $request->nama_lengkap,
            'username'     => $request->username,
            'no_hp'        => $request->no_hp,
            'wilayah'      => $request->wilayah,
            'password'     => bcrypt($request->password)
        ]);

        User::create([
            'name'     => $request->nama_lengkap,
            'username' => $request->username,
            'email'    => $request->username . '@ao.bantul.id',
            'password' => bcrypt($request->password),
            'role'     => 'AO'
        ]);

        return response()->json([
            'message' => 'Akun AO berhasil dibuat',
            'data'    => $ao
        ], 201);
    }

    // GET single AO
    public function show($id)
    {
        $ao = AccountOfficer::find($id);

        if (!$ao) {
            return response()->json(['message' => 'AO tidak ditemukan'], 404);
        }

        return response()->json([
            'message' => 'Data AO ditemukan',
            'data'    => $ao
        ]);
    }

    // PUT update AO
    public function update(Request $request, $id)
    {
        $ao = AccountOfficer::find($id);

        if (!$ao) {
            return response()->json(['message' => 'AO tidak ditemukan'], 404);
        }

        $request->validate([
            'nama_lengkap' => 'sometimes|string|max:255',
            'username'     => 'sometimes|string|unique:account_officers,username,' . $id . '|max:100',
            'no_hp'        => 'sometimes|string|min:10|max:13',
            'wilayah'      => 'sometimes|string|in:Bambanglipuro,Banguntapan,Bantul,Dlingo,Imogiri,Jetis,Kasihan,Kretek,Pajangan,Pandak,Piyungan,Pleret,Pundong,Sanden,Sedayu,Sewon,Srandakan',
            'password'     => 'sometimes|min:8'
        ]);

        if ($request->has('password')) {
            $request->merge(['password' => bcrypt($request->password)]);
        }

        $ao->update($request->only(['nama_lengkap', 'username', 'no_hp', 'wilayah', 'password']));

        return response()->json([
            'message' => 'Akun AO berhasil diperbarui',
            'data'    => $ao
        ]);
    }

    // DELETE AO
    public function destroy($id)
    {
        $ao = AccountOfficer::find($id);

        if (!$ao) {
            return response()->json(['message' => 'AO tidak ditemukan'], 404);
        }

        $ao->delete();

        return response()->json([
            'message' => 'Akun AO berhasil dihapus'
        ]);
    }
}