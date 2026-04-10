<?php

namespace App\Http\Controllers;

use App\Models\AreaParkir;
use App\Models\Kendaraan;
use App\Models\LogAktivitas;
use App\Models\Tarif;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function dashboard()
    {
        $totalUsers = User::where('status_aktif', true)->count();
        $totalPetugas = User::where('status_aktif', true)->where('role', 'petugas')->count();
        $totalOwner = User::where('status_aktif', true)->where('role', 'owner')->count();
        $totalTarifs = Tarif::count();
        $totalAreas = AreaParkir::count();

        return view('admin.dashboard', compact('totalUsers', 'totalPetugas', 'totalOwner', 'totalTarifs', 'totalAreas'));
    }

    // CRUD User
    public function users()
    {
        $users = User::orderBy('nama_lengkap')->paginate(10);

        return view('admin.users.index', compact('users'));
    }

    public function createUser()
    {
        return view('admin.users.create');
    }

    public function storeUser(Request $request)
    {
        $request->validate([
            'nama_lengkap' => 'required|string|max:50',
            'username' => 'required|string|max:50|unique:tb_user',
            'password' => 'required|string|min:6',
            'role' => 'required|in:admin,petugas,owner',
        ]);

        User::create([
            'nama_lengkap' => $request->nama_lengkap,
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'status_aktif' => true,
        ]);

        return redirect()->route('admin.users')->with('success', 'User berhasil ditambahkan.');
    }

    public function editUser(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    public function updateUser(Request $request, User $user)
    {
        $request->validate([
            'nama_lengkap' => 'required|string|max:50',
            'username' => 'required|string|max:50|unique:tb_user,username,'.$user->id_user.',id_user',
            'password' => 'nullable|string|min:6',
            'role' => 'required|in:admin,petugas,owner',
            'status_aktif' => 'required|boolean',
        ]);

        $user->update([
            'nama_lengkap' => $request->nama_lengkap,
            'username' => $request->username,
            'password' => $request->password ? Hash::make($request->password) : $user->password,
            'role' => $request->role,
            'status_aktif' => $request->status_aktif,
        ]);

        return redirect()->route('admin.users')->with('success', 'User berhasil diupdate.');
    }

    public function deleteUser(User $user)
    {
        $user->update(['status_aktif' => false]);

        return redirect()->route('admin.users')->with('success', 'User berhasil dinonaktifkan.');
    }

    // CRUD Tarif
    public function tarifs()
    {
        $tarifs = Tarif::orderBy('jenis_kendaraan')->paginate(10);

        return view('admin.tarifs.index', compact('tarifs'));
    }

    public function createTarif()
    {
        return view('admin.tarifs.create');
    }

    public function storeTarif(Request $request)
    {
        $request->validate([
            'jenis_kendaraan' => 'required|in:motor,mobil,lainnya',
            'tarif_per_jam' => 'required|numeric|min:0',
        ]);

        Tarif::create($request->all());

        return redirect()->route('admin.tarifs')->with('success', 'Tarif berhasil ditambahkan.');
    }

    public function editTarif(Tarif $tarif)
    {
        return view('admin.tarifs.edit', compact('tarif'));
    }

    public function updateTarif(Request $request, Tarif $tarif)
    {
        $request->validate([
            'jenis_kendaraan' => 'required|in:motor,mobil,lainnya',
            'tarif_per_jam' => 'required|numeric|min:0',
        ]);

        $tarif->update($request->all());

        return redirect()->route('admin.tarifs')->with('success', 'Tarif berhasil diupdate.');
    }

    public function deleteTarif(Tarif $tarif)
    {
        $tarif->delete();

        return redirect()->route('admin.tarifs')->with('success', 'Tarif berhasil dihapus.');
    }

    // CRUD Area Parkir
    public function areas()
    {
        $areas = AreaParkir::orderBy('nama_area')->paginate(9);

        return view('admin.areas.index', compact('areas'));
    }

    public function createArea()
    {
        return view('admin.areas.create');
    }

    public function storeArea(Request $request)
    {
        $request->validate([
            'nama_area' => 'required|string|max:50',
            'kapasitas' => 'required|integer|min:1',
        ]);

        AreaParkir::create([
            'nama_area' => $request->nama_area,
            'kapasitas' => $request->kapasitas,
            'terisi' => 0,
        ]);

        return redirect()->route('admin.areas')->with('success', 'Area parkir berhasil ditambahkan.');
    }

    public function editArea(AreaParkir $area)
    {
        return view('admin.areas.edit', compact('area'));
    }

    public function updateArea(Request $request, AreaParkir $area)
    {
        $request->validate([
            'nama_area' => 'required|string|max:50',
            'kapasitas' => 'required|integer|min:1',
        ]);

        $area->update($request->only(['nama_area', 'kapasitas']));

        return redirect()->route('admin.areas')->with('success', 'Area parkir berhasil diupdate.');
    }

    public function deleteArea(AreaParkir $area)
    {
        $area->delete();

        return redirect()->route('admin.areas')->with('success', 'Area parkir berhasil dihapus.');
    }

    // CRUD Kendaraan
    public function kendaraans()
    {
        $kendaraans = Kendaraan::with('user')->orderBy('plat_nomor')->paginate(10);

        return view('admin.kendaraans.index', compact('kendaraans'));
    }

    public function createKendaraan()
    {
        $users = User::where('status_aktif', true)->get();

        return view('admin.kendaraans.create', compact('users'));
    }

    public function storeKendaraan(Request $request)
    {
        $request->validate([
            'plat_nomor' => 'required|string|max:15|unique:tb_kendaraan',
            'jenis_kendaraan' => 'required|string|max:20',
            'warna' => 'required|string|max:20',
            'pemilik' => 'required|string|max:100',
            'id_user' => 'required|exists:tb_user,id_user',
        ]);

        Kendaraan::create($request->all());

        return redirect()->route('admin.kendaraans')->with('success', 'Kendaraan berhasil ditambahkan.');
    }

    public function editKendaraan(Kendaraan $kendaraan)
    {
        $users = User::where('status_aktif', true)->get();

        return view('admin.kendaraans.edit', compact('kendaraan', 'users'));
    }

    public function updateKendaraan(Request $request, Kendaraan $kendaraan)
    {
        $request->validate([
            'plat_nomor' => 'required|string|max:15|unique:tb_kendaraan,plat_nomor,'.$kendaraan->id_kendaraan.',id_kendaraan',
            'jenis_kendaraan' => 'required|string|max:20',
            'warna' => 'required|string|max:20',
            'pemilik' => 'required|string|max:100',
            'id_user' => 'required|exists:tb_user,id_user',
        ]);

        $kendaraan->update($request->all());

        return redirect()->route('admin.kendaraans')->with('success', 'Kendaraan berhasil diupdate.');
    }

    public function deleteKendaraan(Kendaraan $kendaraan)
    {
        $kendaraan->delete();

        return redirect()->route('admin.kendaraans')->with('success', 'Kendaraan berhasil dihapus.');
    }

    // Log Aktivitas
    public function logs(Request $request)
    {
        $query = LogAktivitas::with('user');

        if ($request->has('tanggal') && $request->tanggal) {
            $query->whereDate('waktu_aktivitas', $request->tanggal);
        }

        $logs = $query->orderBy('waktu_aktivitas', 'desc')->paginate(20)->withQueryString();

        return view('admin.logs.index', compact('logs'));
    }
}
