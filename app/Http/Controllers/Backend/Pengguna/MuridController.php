<?php

namespace App\Http\Controllers\Backend\Pengguna;

use App\Http\Controllers\Controller;
use App\Models\dataMurid;
use App\Models\User;
use App\Models\Kelas;
use App\Models\DataOrtu; // <-- Add DataOrtu model
use App\Models\BerkasMurid; // <-- Add BerkasMurid model
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use ErrorException;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class MuridController extends Controller
{


    public function index()
    {
        // Eager load necessary relationships for index view
        $murid = User::with("kelas", "muridDetail")->whereIn("role", ["Murid"])->get();
        return view("backend.pengguna.murid.index", compact("murid"));
    }



    public function create()
    {
        $kelas = Kelas::all(); // Pass kelas data to create view
        return view("backend.pengguna.murid.create", compact("kelas"));
    }


    public function store(Request $request)
    {
        try {
            DB::beginTransaction();

            $validator = Validator::make($request->all(), [
                "name" => "required|string|max:255",
                "email" => "required|email|unique:users,email",
                "password" => "nullable|string|min:6", // Allow nullable for default, but good to validate if provided
                "jenis_kelamin" => "required|in:L,P",
                "whatsapp" => "nullable|string|max:15|unique:data_murids,whatsapp", // Added unique validation for whatsapp
                "kelas" => "required|exists:kelas,id",
                "nis" => ["nullable", "string", "max:50", "unique:data_murids,nis"],
                "nisn" => ["nullable", "string", "max:50", "unique:data_murids,nisn"],
                "tempat_lahir" => "nullable|string|max:100",
                "tgl_lahir" => "nullable|date",
                "agama" => "nullable|string|max:50",
                "alamat" => "nullable|string",
                "foto_profile" => "nullable|image|mimes:jpeg,png,jpg,gif|max:2048", // Max 2MB

                // Data Ortu validation (assuming these fields might be submitted during creation)
                "nama_ayah" => "nullable|string|max:255",
                "pendidikan_ayah" => "nullable|string|max:100",
                "pekerjaan_ayah" => "nullable|string|max:100",
                "alamat_ayah" => "nullable|string",
                "nama_ibu" => "nullable|string|max:255",
                "pendidikan_ibu" => "nullable|string|max:100",
                "pekerjaan_ibu" => "nullable|string|max:100",
                "alamat_ibu" => "nullable|string",

                // Berkas validation (assuming these might be submitted during creation)
                "kartu_keluarga" => "nullable|file|mimes:pdf,jpg,jpeg,png|max:5120", // Max 5MB
                "akte_kelahiran" => "nullable|file|mimes:pdf,jpg,jpeg,png|max:5120",
                "ktp" => "nullable|file|mimes:pdf,jpg,jpeg,png|max:5120",
                "foto" => "nullable|file|mimes:pdf,jpg,jpeg,png|max:5120",
            ],
            [
                "name.required" => "Nama tidak boleh kosong.",
                "email.required" => "Email tidak boleh kosong.",
                "email.unique" => "Email sudah pernah digunakan.",
                "email.email" => "Email yang dimasukan tidak valid.",
                "password.min" => "Password minimal 6 karakter.",
                "jenis_kelamin.required" => "Jenis kelamin harus dipilih.",
                "jenis_kelamin.in" => "Jenis kelamin harus L atau P.",
                "whatsapp.max" => "Nomor WhatsApp maksimal 15 karakter.",
                "whatsapp.unique" => "Nomor WhatsApp sudah digunakan oleh murid lain.",
                "kelas.required" => "Kelas harus dipilih.",
                "kelas.exists" => "Kelas yang dipilih tidak valid.",
                "nis.unique" => "NIS sudah digunakan.",
                "nisn.unique" => "NISN sudah digunakan.",
                "foto_profile.image" => "File foto profil harus berupa gambar.",
                "foto_profile.mimes" => "Format foto profil harus jpeg, png, jpg, atau gif.",
                "foto_profile.max" => "Ukuran foto profil maksimal 2MB.",
                "kartu_keluarga.mimes" => "Format file Kartu Keluarga harus pdf, jpg, jpeg, atau png.",
                "kartu_keluarga.max" => "Ukuran file Kartu Keluarga maksimal 5MB.",
                // Tambahkan pesan error untuk berkas lainnya jika diperlukan
            ]
            );

            if ($validator->fails()) {
                return redirect()->back()
                    ->withErrors($validator)
                    ->withInput();
            }

            $nama_img = null;
            if ($request->hasFile("foto_profile")) {
                $image = $request->file("foto_profile");
                $nama_img = time() . "_" . uniqid() . "." . $image->getClientOriginalExtension(); // Menggunakan uniqid untuk nama file yang lebih unik
                $tujuan_upload = "public/images/profile";
                $path = $image->storeAs($tujuan_upload, $nama_img);
                if (!$path) {
                    throw new \Exception("Gagal menyimpan foto profil.");
                }
            }

            $username = $this->generateUniqueUsername($request->name);

            $murid = new User();
            $murid->name = $request->name;
            $murid->username = $username;
            $murid->email = $request->email;
            $murid->role = "Murid";
            $murid->status = "Aktif"; // Default status for new students
            $murid->foto_profile = $nama_img;
            $murid->password = bcrypt($request->password ?? "password"); // Default password if not provided
            $murid->kelas_id = $request->kelas;
            $murid->save();

            // Create Murid Detail
            dataMurid::create([
                "user_id" => $murid->id,
                "jenis_kelamin" => $request->jenis_kelamin,
                "whatsapp" => $request->whatsapp,
                "nis" => $request->nis,
                "nisn" => $request->nisn,
                "tempat_lahir" => $request->tempat_lahir,
                "tgl_lahir" => $request->tgl_lahir,
                "agama" => $request->agama,
                "alamat" => $request->alamat,
            ]);

            // Create Data Ortu (only if data is provided)
            if ($request->filled(["nama_ayah", "nama_ibu"])) { // Check if at least parent names are provided
                DataOrtu::create([
                    "user_id" => $murid->id,
                    "nama_ayah" => $request->nama_ayah,
                    "pendidikan_ayah" => $request->pendidikan_ayah,
                    "pekerjaan_ayah" => $request->pekerjaan_ayah,
                    "alamat_ayah" => $request->alamat_ayah,
                    "nama_ibu" => $request->nama_ibu,
                    "pendidikan_ibu" => $request->pendidikan_ibu,
                    "pekerjaan_ibu" => $request->pekerjaan_ibu,
                    "alamat_ibu" => $request->alamat_ibu,
                ]);
            }

            // Create Berkas Murid (only if any file is uploaded)
            $hasBerkasFile = false;
            $berkasFields = ["kartu_keluarga", "akte_kelahiran", "ktp", "foto"];
            foreach ($berkasFields as $field) {
                if ($request->hasFile($field)) {
                    $hasBerkasFile = true;
                    break;
                }
            }

            if ($hasBerkasFile) {
                $berkasMurid = BerkasMurid::create(["user_id" => $murid->id]);
                $uploadPathBerkas = "public/images/berkas_murid";

                foreach ($berkasFields as $field) {
                    if ($request->hasFile($field)) {
                        $file = $request->file($field);
                        $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                        $safeName = preg_replace("/[^A-Za-z0-9_\-\.]/", "_", $originalName);
                        $extension = $file->getClientOriginalExtension();
                        $nama_file_berkas = time() . "_" . $safeName . "." . $extension;

                        $pathBerkas = $file->storeAs($uploadPathBerkas, $nama_file_berkas);
                        if (!$pathBerkas) {
                            throw new \Exception("Gagal menyimpan berkas: " . $field);
                        }
                        $berkasMurid->$field = $nama_file_berkas;
                    }
                }
                $berkasMurid->save();
            }

            $murid->assignRole($murid->role);

            DB::commit();
            Session::flash("success", "Murid Berhasil disimpan!");
            return redirect()->route("backend-pengguna-murid.index");
        } catch (\Exception $e) {
            DB::rollback();
            Log::error("Error storing Murid: " . $e->getMessage() . " di baris " . $e->getLine());
            Session::flash("error", "Gagal menyimpan Murid: " . $e->getMessage() . " (Baris: " . $e->getLine() . ")");
            return redirect()->back()->withInput();
        }
    }

    /**
     * Helper function to generate a unique username.
     */
    protected function generateUniqueUsername($name)
    {
        $baseUsername = strtolower(str_replace(' ', '', preg_replace('/[^A-Za-z0-9 ]/', '', $name))); // Remove non-alphanumeric and spaces
        $username = $baseUsername;
        $counter = 1;
        while (User::where('username', $username)->exists()) {
            $username = $baseUsername . $counter;
            $counter++;
        }
        return $username;
    }

    public function show($id)
    {
        // Eager load all necessary relationships for detail view
        $murid = User::with(["kelas", "muridDetail", "dataOrtu", "berkas"])->findOrFail($id);
        return view("backend.pengguna.murid.detail", compact("murid"));
    }

    
    public function edit($id)
    {
        // Eager load all necessary relationships for edit view
        $murid = User::with(["muridDetail", "kelas", "dataOrtu", "berkas"])
            ->whereIn("role",["Guest", "Murid"])
            ->findOrFail($id);
        $kelas = Kelas::all();
        return view("backend.pengguna.murid.edit", compact("murid", "kelas"));
    }

public function update(Request $request, $id)
    {
        // --- Updated Validation Rules ---
        $validator = Validator::make($request->all(), [
            "name" => "required|max:255",
            "email" => [
                "required",
                "email",
                Rule::unique("users")->ignore($id),
            ],
            "status" => [
                "required",
                Rule::in(["Aktif", "Tidak Aktif"]),
            ],
            "kelas" => "required|exists:kelas,id",
            "nis" => [
                "nullable",
                "string",
                "max:50",
                Rule::unique("data_murids", "nis")->ignore($id, "user_id"),
            ],
            "nisn" => [
                "nullable",
                "string",
                "max:50",
                Rule::unique("data_murids", "nisn")->ignore($id, "user_id"),
            ],
            "tahun_ajaran" => [
                "nullable",
                "string",
                "max:50",
                Rule::unique("data_murids", "tahun_ajaran")->ignore($id, "user_id"),
            ],
            "whatsapp" => [
                "nullable",
                "string",
                "max:15",
                // Consider if whatsapp needs to be unique per user or globally
                  Rule::unique("data_murids", "whatsapp")->ignore($id, "user_id"),
            ],
            "tempat_lahir" => "nullable|string|max:100",
            "tgl_lahir" => "nullable|date",
            "jenis_kelamin" => "required|in:L,P",
            "agama" => "nullable|string|max:50",
            "alamat" => "nullable|string",

            "foto_profile" => "nullable|file|mimes:jpeg,png,jpg,gif,pdf|max:2048", // Max 2MB
            // Berkas validation (adjust mimes and max size as needed)
            "kartu_keluarga" => "nullable|file|mimes:pdf,jpg,jpeg,png|max:5120", // Max 5MB
            "akte_kelahiran" => "nullable|file|mimes:pdf,jpg,jpeg,png|max:5120",
            "ktp" => "nullable|file|mimes:pdf,jpg,jpeg,png|max:5120",
            "foto" => "nullable|file|mimes:pdf,jpg,jpeg,png|max:5120",
            // Data Ortu validation
            "nama_ayah" => "nullable|string|max:255",
            "pendidikan_ayah" => "nullable|string|max:100",
            "pekerjaan_ayah" => "nullable|string|max:100",
            "alamat_ayah" => "nullable|string",
            "nama_ibu" => "nullable|string|max:255",
            "pendidikan_ibu" => "nullable|string|max:100",
            "pekerjaan_ibu" => "nullable|string|max:100",
            "alamat_ibu" => "nullable|string",
        ],
        [
            // --- Add Custom Error Messages --- 
            "name.required" => "Nama tidak boleh kosong.",
            "email.required" => "Email tidak boleh kosong.",
            "email.email" => "Email yang dimasukan tidak valid.",
            "email.unique" => "Email sudah digunakan oleh pengguna lain.",
            "status.required" => "Status Murid harus dipilih.",
            "status.in" => "Status yang dipilih tidak valid.",
            "kelas.required" => "Kelas harus dipilih.",
            "kelas.exists" => "Kelas yang dipilih tidak valid.",
            "nis.unique" => "NIS sudah digunakan oleh murid lain.",
            "nisn.unique" => "NISN sudah digunakan oleh murid lain.",
            "tahun_ajaran.unique" => "Tahun ajaran sudah digunakan oleh murid lain.",
            "whatsapp.max" => "Nomor WhatsApp maksimal 15 karakter.",
            "whatsapp.unique" => "Nomor WhatsApp sudah digunakan oleh murid lain.",
            "jenis_kelamin.required" => "Jenis kelamin harus dipilih.",



            "foto_profile.file" => "File tidak valid.",
            "foto_profile.mimes" => "Format file harus jpeg, png, jpg, gif, atau pdf.",
            "foto_profile.max" => "Ukuran file maksimal 2MB.",
            "kartu_keluarga.mimes" => "Format file Kartu Keluarga harus pdf, jpg, jpeg, atau png.",
            "kartu_keluarga.max" => "Ukuran file Kartu Keluarga maksimal 5MB.",
            // Add messages for other file uploads and fields...
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            DB::beginTransaction();

            $murid = User::findOrFail($id);

            // --- Handle Foto Profile Upload --- 
            $nama_img = $murid->foto_profile;
            if ($request->hasFile("foto_profile")) {
                // Delete old image if exists
                if ($murid->foto_profile && Storage::exists("public/images/profile/" . $murid->foto_profile)) {
                    Storage::delete("public/images/profile/" . $murid->foto_profile);
                }
                // Store new image


                $file = $request->file("foto_profile");
                $nama_img = time() . "_" . $file->getClientOriginalName();
                $tujuan_upload = "public/images/profile";

                $path = $file->storeAs($tujuan_upload, $nama_img);
                  if (!$path) {
                    throw new \Exception("Gagal menyimpan foto profil baru.");
                }
            }

            // --- Update User Data --- 
            $murid->name = $request->name;
            $murid->email = $request->email;
            $murid->status = $request->status;
            $murid->kelas_id = $request->kelas;
            $murid->foto_profile = $nama_img; // Update foto profile name
            // Optionally update password if provided
            if ($request->filled("password")) {
                  $murid->password = bcrypt($request->password);
            }
            $murid->save();

            // --- Update dataMurid --- 
            $detailMurid = dataMurid::firstOrCreate(["user_id" => $murid->id]);
            $detailMurid->nis = $request->nis;
            $detailMurid->nisn = $request->nisn;
            $detailMurid->tahun_ajaran = $request->tahun_ajaran;
            $detailMurid->whatsapp = $request->whatsapp;
            $detailMurid->tempat_lahir = $request->tempat_lahir;
            $detailMurid->tgl_lahir = $request->tgl_lahir;
            $detailMurid->jenis_kelamin = $request->jenis_kelamin;
            $detailMurid->agama = $request->agama;
            $detailMurid->alamat = $request->alamat;
            $detailMurid->save();

            // --- Handle Berkas Upload --- 
            $berkasMurid = \Modules\PPDB\Entities\BerkasMurid::firstOrCreate(["user_id" => $murid->id]);
            $berkasFields = ["kartu_keluarga", "akte_kelahiran", "ktp", "foto"];
            $uploadPathBerkas = "public/images/berkas_murid";

            foreach ($berkasFields as $field) {
                if ($request->hasFile($field)) {
                    // Delete old file if exists
                    if ($berkasMurid->$field && Storage::exists($uploadPathBerkas . "/" . $berkasMurid->$field)) {
                        Storage::delete($uploadPathBerkas . "/" . $berkasMurid->$field);
                    }
                    // Store new file
                    $file = $request->file($field);
                    // Sanitize filename (optional but recommended)
                    $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                    $safeName = preg_replace("/[^A-Za-z0-9_\-\.]/", "_", $originalName);
                    $extension = $file->getClientOriginalExtension();
                    $nama_file_berkas = time() . "_" . $safeName . "." . $extension;
                    
                    $pathBerkas = $file->storeAs($uploadPathBerkas, $nama_file_berkas);
                      if (!$pathBerkas) {
                        throw new \Exception("Gagal menyimpan berkas: " . $field);
                    }
                    $berkasMurid->$field = $nama_file_berkas; // Save the new filename
                }
            }
            $berkasMurid->save();

            // --- Update Data Ortu --- 
            $dataOrtu = \Modules\PPDB\Entities\DataOrangTua::firstOrCreate(["user_id" => $murid->id]);
            $dataOrtu->nama_ayah = $request->nama_ayah;
            $dataOrtu->pendidikan_ayah = $request->pendidikan_ayah;
            $dataOrtu->pekerjaan_ayah = $request->pekerjaan_ayah;
            $dataOrtu->alamat_ayah = $request->alamat_ayah;
            $dataOrtu->nama_ibu = $request->nama_ibu;
            $dataOrtu->pendidikan_ibu = $request->pendidikan_ibu;
            $dataOrtu->pekerjaan_ibu = $request->pekerjaan_ibu;
            $dataOrtu->alamat_ibu = $request->alamat_ibu;
            $dataOrtu->save();

            DB::commit();
            Session::flash("success", "Data Murid Berhasil diupdate !");
            return redirect()->route("backend-pengguna-murid.index");
        } catch (\Exception $e) {
            DB::rollback();
            Log::error("Error updating Murid: " . $e->getMessage() . " di baris " . $e->getLine());
            Session::flash("error", "Gagal mengupdate Data Murid: " . $e->getMessage());
            return redirect()->back()->withInput();
        }
    }


    public function destroy($id)
    {
        try {
            DB::beginTransaction();
            $murid = User::findOrFail($id);

            // Delete related data first to avoid foreign key constraints
            dataMurid::where("user_id", $id)->delete();
            DataOrtu::where("user_id", $id)->delete(); // Delete DataOrtu
            
            // Delete Berkas files and record
            $berkas = BerkasMurid::where("user_id", $id)->first();
            if ($berkas) {
                 $berkasFields = ["kartu_keluarga", "akte_kelahiran", "ktp", "foto"];
                 $uploadPathBerkas = "public/images/berkas_murid";
                 foreach ($berkasFields as $field) {
                     if ($berkas->$field && Storage::exists($uploadPathBerkas . "/" . $berkas->$field)) {
                        Storage::delete($uploadPathBerkas . "/" . $berkas->$field);
                    }
                 }
                 $berkas->delete();
            }

            // Delete Foto Profile file
            if ($murid->foto_profile && Storage::exists("public/images/profile/" . $murid->foto_profile)) {
                Storage::delete("public/images/profile/" . $murid->foto_profile);
            }

            // Detach roles
            DB::table("model_has_roles")
                ->where("model_id", $id)
                ->delete();

            // Delete the user
            $murid->delete();

            DB::commit();
            Session::flash("success", "Data Murid berhasil dihapus.");
        } catch (\Exception $e) {
            DB::rollback();
            Log::error("Error deleting Murid: " . $e->getMessage());
            Session::flash("error", "Gagal menghapus Data Murid.");
        }
        return redirect()->route("backend-pengguna-murid.index");
    }
}

