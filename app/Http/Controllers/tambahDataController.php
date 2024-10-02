<?php

namespace App\Http\Controllers;

use App\Models\dataAnak;
use Illuminate\Http\Request;

class tambahDataController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function index()
    {
        $anak = dataAnak::with('gizi')->get();
        return view('page/tambahData', compact('anak'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // return view("page/tambahData");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

     public function store(Request $request)
     {
         try {
             // Define custom error messages
             $messages = [
                 'nama_anak.required' => 'Nama anak harus diisi.',
                 'nama_anak.regex' => 'Nama anak hanya boleh mengandung huruf.',
                 'nik.required' => 'NIK harus diisi.',
                 'nik.size' => 'NIK harus terdiri dari 16 karakter.',
                 'nik.unique' => 'NIK yang Anda masukkan sudah terdaftar.',
                 'tempat_lahir.required' => 'Tempat lahir harus diisi.',
                 'tanggal_lahir.required' => 'Tanggal lahir harus diisi.',
                 'tanggal_lahir.date' => 'Format tanggal lahir harus valid.',
                 'tanggal_lahir.before_or_equal' => 'Tanggal lahir tidak boleh lebih dari tanggal saat ini.',
                 'jenis_kelamin.required' => 'Jenis kelamin harus diisi.',
                 'jenis_kelamin.in' => 'Jenis kelamin harus Laki-Laki atau Perempuan.',
                 'kecamatan.required' => 'Kecamatan harus diisi.',
                 'kecamatan.in' => 'Kecamatan yang dipilih tidak valid.',
                 'detail_alamat.required' => 'Alamat detail harus diisi.'
             ];
     
             // Validate the form data with custom messages
             $validatedData = $request->validate([
                 'nama_anak' => 'required|string|max:255|regex:/^[a-zA-Z\s]*$/',
                 'nik' => 'required|string|size:16|unique:anak,nik',
                 'tempat_lahir' => 'required|string|max:255',
                 'tanggal_lahir' => 'required|date|before_or_equal:today',
                 'jenis_kelamin' => 'required|in:Laki-Laki,Perempuan',
                 'kecamatan' => 'required|in:Bayat,Cawas,Ceper,Delanggu,Gantiwarno,Jatinom,Jogonalan,Kalikotes,Karanganom,Karangdowo,Kemalang,Klaten Selatan,Klaten Tengah,Klaten Utara,Manisrenggo,Ngawen,Pedan,Polanharjo,Prambanan,Trucuk,Tulung,Wedi,Wonosari',
                 'detail_alamat' => 'required|string'
             ], $messages);
     
             // Save the post to the database
             dataAnak::create($validatedData);
     
             // Redirect back with a success message
             return redirect('/tambahData')->with('success', 'Data berhasil disimpan!');
         } catch (\Illuminate\Validation\ValidationException $e) {
             // Handle the validation exception and return back with the input and errors
             return redirect()->back()->withInput()->withErrors($e->errors());
         } catch (\Exception $e) {
             // Handle general exceptions
             return redirect()->back()->with('error', 'Terjadi kesalahan saat menyimpan data: ' . $e->getMessage());
         }
     }
     
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $anak = dataAnak::with('gizi')->findOrFail($id);
        return view('page/cekStatus', compact('anak'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $item = dataAnak::findOrFail($id);
        return response()->json($item); // Return the item data as JSON
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'nama_anak' => 'required|string|max:255',
            'tempat_lahir' => 'required|string|max:255',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required|in:Laki-Laki,Perempuan',
            'kecamatan' => 'required|in:Bayat,Cawas,Ceper,Delanggu,Gantiwarno,Jatinom,Jogonalan,Kalikotes,Karanganom,Karangdowo,Kemalang,Klaten Selatan,Klaten Tengah,Klaten Utara,Manisrenggo,Ngawen,Pedan,Polanharjo,Prambanan,Trucuk,Tulung,Wedi,Wonosa',
            'detail_alamat' => 'required|string'
        ]);
    
        $data = dataAnak::findOrFail($id);
        $data->update($validatedData);
    
        return redirect()->route('page.lihatData')->with('success', 'Data berhasil diperbarui.');
    }
    

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = dataAnak::findOrFail($id);
        
        // Periksa apakah data anak memiliki riwayat pemeriksaan
        if ($data->allGiziRecords()->exists()) {
            // Jika ada riwayat pemeriksaan, jangan hapus dan kembalikan pesan error
            return redirect()->route('page.lihatData')->with('error', 'Data anak tidak dapat dihapus karena memiliki riwayat pemeriksaan.');
        }
        
        // Jika tidak ada riwayat pemeriksaan, hapus data anak
        $data->delete();
        return redirect()->route('page.lihatData')->with('success', 'Data berhasil dihapus.');
    }
    
}
