<?php

namespace App\Http\Controllers;

use App\Models\AreaParkir;
use App\Models\Kendaraan;
use App\Models\LogAktivitas;
use App\Models\Tarif;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

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
            'status_aktif' => 'required|boolean',
        ]);

        User::create([
            'nama_lengkap' => $request->nama_lengkap,
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'status_aktif' => $request->boolean('status_aktif'),
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

        if (Auth::id() === $user->id_user && ! $request->boolean('status_aktif')) {
            return back()
                ->withErrors(['status_aktif' => 'Anda tidak dapat menonaktifkan akun Anda sendiri.'])
                ->withInput();
        }

        $user->update([
            'nama_lengkap' => $request->nama_lengkap,
            'username' => $request->username,
            'password' => $request->password ? Hash::make($request->password) : $user->password,
            'role' => $request->role,
            'status_aktif' => $request->boolean('status_aktif'),
        ]);

        return redirect()->route('admin.users')->with('success', 'User berhasil diupdate.');
    }

    public function deleteUser(User $user)
    {
        if (Auth::id() === $user->id_user) {
            return redirect()->route('admin.users')
                ->withErrors(['user' => 'Anda tidak dapat menonaktifkan akun Anda sendiri.']);
        }

        $user->update(['status_aktif' => false]);

        return redirect()->route('admin.users')->with('success', 'User berhasil dinonaktifkan.');
    }

    // CRUD Tarif
    public function tarifs()
    {
        $tarifs = Tarif::with(['areaParkir:id_area,nama_area'])
            ->withCount('transaksis')
            ->orderBy('id_area')
            ->orderBy('jenis_kendaraan')
            ->paginate(10);

        return view('admin.tarifs.index', compact('tarifs'));
    }

    public function createTarif()
    {
        $areas = AreaParkir::orderBy('nama_area')->get(['id_area', 'nama_area']);

        return view('admin.tarifs.create', compact('areas'));
    }

    public function storeTarif(Request $request)
    {
        $request->validate([
            'id_area' => ['required', 'exists:tb_area_parkir,id_area'],
            'jenis_kendaraan' => [
                'required',
                'in:motor,mobil,lainnya',
                Rule::unique('tb_tarif', 'jenis_kendaraan')->where(function ($query) use ($request): void {
                    $query->where('id_area', $request->integer('id_area'));
                }),
            ],
            'tarif_per_jam' => 'required|numeric|min:0',
        ], [
            'id_area.required' => 'Pilih area parkir tempat tarif ini berlaku.',
            'id_area.exists' => 'Area parkir yang dipilih tidak ditemukan.',
            'jenis_kendaraan.unique' => 'Untuk area parkir ini, jenis kendaraan tersebut sudah memiliki tarif. Silakan edit tarif yang sudah ada.',
        ]);

        Tarif::create($request->only(['id_area', 'jenis_kendaraan', 'tarif_per_jam']));

        return redirect()->route('admin.tarifs')->with('success', 'Tarif berhasil ditambahkan.');
    }

    public function editTarif(Tarif $tarif)
    {
        $areas = AreaParkir::orderBy('nama_area')->get(['id_area', 'nama_area']);

        return view('admin.tarifs.edit', compact('tarif', 'areas'));
    }

    public function updateTarif(Request $request, Tarif $tarif)
    {
        $request->validate([
            'id_area' => ['required', 'exists:tb_area_parkir,id_area'],
            'jenis_kendaraan' => [
                'required',
                'in:motor,mobil,lainnya',
                Rule::unique('tb_tarif', 'jenis_kendaraan')
                    ->where(function ($query) use ($request): void {
                        $query->where('id_area', $request->integer('id_area'));
                    })
                    ->ignore($tarif->id_tarif, 'id_tarif'),
            ],
            'tarif_per_jam' => 'required|numeric|min:0',
        ], [
            'id_area.required' => 'Pilih area parkir tempat tarif ini berlaku.',
            'id_area.exists' => 'Area parkir yang dipilih tidak ditemukan.',
            'jenis_kendaraan.unique' => 'Untuk area parkir ini, jenis kendaraan tersebut sudah memiliki tarif. Silakan pilih jenis lain atau edit tarif yang sudah ada.',
        ]);

        $tarif->update($request->only(['id_area', 'jenis_kendaraan', 'tarif_per_jam']));

        return redirect()->route('admin.tarifs')->with('success', 'Tarif berhasil diupdate.');
    }

    public function deleteTarif(Tarif $tarif)
    {
        if ($tarif->transaksis()->exists()) {
            return redirect()->route('admin.tarifs')
                ->withErrors(['tarif' => 'Tarif tidak bisa dihapus karena sudah dipakai dalam transaksi.']);
        }

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
        $areas = AreaParkir::query()
            ->orderBy('nama_area')
            ->with([
                'transaksis' => function ($query): void {
                    $query->where('status', 'masuk')
                        ->with(['kendaraan.user'])
                        ->orderByDesc('waktu_masuk');
                },
            ])
            ->get();

        $kendaraansBelumParkir = Kendaraan::query()
            ->with('user')
            ->whereDoesntHave('transaksis', function ($query): void {
                $query->where('status', 'masuk');
            })
            ->orderBy('plat_nomor')
            ->get();

        return view('admin.kendaraans.index', compact('areas', 'kendaraansBelumParkir'));
    }

    public function createKendaraan()
    {
        $users = User::where('status_aktif', true)->get();

        return view('admin.kendaraans.create', compact('users'));
    }

    public function storeKendaraan(Request $request)
    {
        $request->merge([
            'plat_nomor' => Kendaraan::normalizePlatNomor($request->input('plat_nomor')),
        ]);

        $request->validate([
            'plat_nomor' => ['required', 'string', 'max:15', 'regex:'.Kendaraan::INDONESIA_PLATE_NUMBER_REGEX, 'unique:tb_kendaraan'],
            'jenis_kendaraan' => 'required|string|max:20',
            'warna' => 'required|string|max:20|regex:/\S/',
            'pemilik' => 'required|string|max:100',
            'id_user' => 'required|exists:tb_user,id_user',
        ], [
            'plat_nomor.regex' => 'Format plat nomor tidak valid. Contoh: B 1234 ABC.',
            'pemilik.required' => 'Nama pemilik wajib diisi.',
            'pemilik.string' => 'Nama pemilik harus berupa teks.',
            'pemilik.min' => 'Nama pemilik minimal :min karakter.',
            'pemilik.max' => 'Nama pemilik maksimal :max karakter.',
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
        $request->merge([
            'plat_nomor' => Kendaraan::normalizePlatNomor($request->input('plat_nomor')),
        ]);

        $request->validate([
            'plat_nomor' => ['required', 'string', 'max:15', 'regex:'.Kendaraan::INDONESIA_PLATE_NUMBER_REGEX, 'unique:tb_kendaraan,plat_nomor,'.$kendaraan->id_kendaraan.',id_kendaraan'],
            'jenis_kendaraan' => 'required|string|max:20',
            'warna' => 'required|string|max:20|regex:/\S/',
            'pemilik' => 'required|string|max:100',
            'id_user' => 'required|exists:tb_user,id_user',
        ], [
            'plat_nomor.regex' => 'Format plat nomor tidak valid. Contoh: B 1234 ABC.',
            'pemilik.required' => 'Nama pemilik wajib diisi.',
            'pemilik.string' => 'Nama pemilik harus berupa teks.',
            'pemilik.min' => 'Nama pemilik minimal :min karakter.',
            'pemilik.max' => 'Nama pemilik maksimal :max karakter.',
        ]);

        $kendaraan->update($request->all());

        return redirect()->route('admin.kendaraans')->with('success', 'Kendaraan berhasil diupdate.');
    }

    public function deleteKendaraan(Kendaraan $kendaraan)
    {
        $kendaraanSedangAktif = $kendaraan->transaksis()
            ->where('status', 'masuk')
            ->exists();

        if ($kendaraanSedangAktif) {
            return redirect()->route('admin.kendaraans')
                ->withErrors(['kendaraan' => 'Kendaraan aktif (sedang terparkir) tidak dapat dihapus.']);
        }

        $kendaraan->delete();

        return redirect()->route('admin.kendaraans')->with('success', 'Kendaraan berhasil dihapus.');
    }

    // Log Aktivitas
    public function logs(Request $request)
    {
        $validated = $request->validate([
            'tanggal' => ['nullable', 'date'],
            'jam' => ['nullable', 'integer', 'between:0,23'],
            'menit' => ['nullable', 'integer', 'between:0,59'],
        ]);

        $tanggal = $validated['tanggal'] ?? null;
        $jam = $validated['jam'] ?? null;
        $menit = $validated['menit'] ?? null;
        $databaseDriver = LogAktivitas::query()->getConnection()->getDriverName();

        $query = LogAktivitas::with('user');

        if ($tanggal) {
            $query->whereDate('waktu_aktivitas', $tanggal);
        }

        if ($jam !== null) {
            if ($databaseDriver === 'sqlite') {
                $query->whereRaw("strftime('%H', waktu_aktivitas) = ?", [sprintf('%02d', $jam)]);
            } else {
                $query->whereRaw('HOUR(waktu_aktivitas) = ?', [$jam]);
            }
        }

        if ($menit !== null) {
            if ($databaseDriver === 'sqlite') {
                $query->whereRaw("strftime('%M', waktu_aktivitas) = ?", [sprintf('%02d', $menit)]);
            } else {
                $query->whereRaw('MINUTE(waktu_aktivitas) = ?', [$menit]);
            }
        }

        $logs = $query->orderBy('waktu_aktivitas', 'desc')->paginate(20)->withQueryString();

        return view('admin.logs.index', compact('logs'));
    }
}
