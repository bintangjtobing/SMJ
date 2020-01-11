<?php

namespace App\Http\Controllers;

use App\CategoriesModel;
use App\itemModel;
use App\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Auth;

class dashboardController extends Controller
{
    public function index()
    {
        return view('dashboard.dash');
    }
    public function utility()
    {
        $kategori = DB::table('categoriesSparepart')
            ->select('categoriesSparepart.*')
            ->get();
        $item = DB::table('items')
            ->select('items.*')
            ->get();
        $itemkategori = DB::table('items')
            ->join('categoriesSparepart', 'categoriesSparepart.id', '=', 'items.kategori_id')
            ->select('items.*', 'categoriesSparepart.*')
            ->get();
        return view('dashboard.utility', ['kategori' => $kategori, 'item' => $item, 'itemkategori' => $itemkategori]);
    }
    public function messages()
    {
        $messages = DB::table('messages')
            ->where('messages.status', '=', ['readed', 'unread'])
            ->select('messages.*')
            ->orderBy('messages.created_at', 'DESC')
            ->paginate(30);

        return view('dashboard.folderpesan.inbox', ['messages' => $messages]);
    }
    public function userconf()
    {
        $userdata = DB::table('users')
            ->select('users.*')
            ->get();
        return view('dashboard.userconf', ['userdata' => $userdata]);
    }
    public function readmessage(Request $request, $message_id)
    {
        $pesanmasuk = \App\MessagesModel::find($message_id);
        $pesanmasuk->status = 'readed';
        $pesanmasuk->save();
        return view('dashboard.folderpesan.read', ['pesanmasuk' => $pesanmasuk]);
    }
    public function trashmessage(Request $request, $message_id)
    {
        $pesanmasuk = \App\MessagesModel::find($message_id);
        $pesanmasuk->status = 'trashed';
        $pesanmasuk->save();
        return back()->with('sukses', 'Pesan berhasil dipindahkan ketempat sampah');
    }
    public function kategoriadd(Request $request)
    {
        $kategori = new \App\CategoriesModel;
        $kategori->nama_kategori  = $request->nama_kategori;
        $kategori->save();

        return back()->with('sukses', 'Yeay, data kategori baru berhasil ditambahkan!');
    }
    public function tambahuser(Request $request)
    {
        $usernew = new \App\User;
        $usernew->name = $request->name;
        $usernew->email = $request->email;
        $usernew->password = Hash::make($request->password);
        $usernew->role = $request->role;
        $usernew->username = $request->username;
        $usernew->status = $request->status;
        $usernew->unpassword = $request->password;
        $usernew->logIP = $request->getClientIp();
        $usernew->login_record = $request->getClientIp();
        $usernew->created_by = Auth()->user()->name;
        $usernew->updated_by = Auth()->user()->name;

        // dd($usernew);
        $usernew->save();
        return back()->with('sukses', 'Yey! Akunmu berhasil didaftarkan. Tunggu hingga admin menyetujui akun barumu dan setelah disetujui, silahkan login kembali.');
    }
    public function itemadd(Request $request)
    {
        $item = new \App\itemModel;
        $item->nama_item  = $request->nama_item;
        $item->kategori_id = $request->kategori_id;
        $item->description = $request->description;
        $item->type_product = $request->type_product;
        if ($request->hasFile('images')) {
            $request->file('images')->move('storage/shop/img/', $request->file('images')->getClientOriginalName());
            $item->images = $request->file('images')->getClientOriginalName();
            $item->save();
        }

        return back()->with('suksesitem', 'Yeay, data produk baru berhasil ditambahkan!');
    }
    public function updatekategori($id)
    {
        $kategori = CategoriesModel::find($id);
        return view('dashboard.editkat', ['kategori' => $kategori]);
    }
    public function prosesupdatekategori(Request $request, $id)
    {
        $datkategori = \App\CategoriesModel::find($id);
        $datkategori->nama_kategori = $request->nama_kategori;
        $datkategori->save();

        return redirect('/utility-item')->with('sukses', 'Kategori nya sudah berhasil diubah! Coba cek ya.. :)');
    }
    public function deletekategori($id)
    {
        $data_kategori = CategoriesModel::find($id);

        if ($data_kategori) {
            if ($data_kategori->delete()) {

                DB::statement('ALTER TABLE categoriesSparepart AUTO_INCREMENT = ' . (count(CategoriesModel::all()) + 1) . ';');

                return back()->with('sukses', 'Kategori berhasil dihapus!');
            }
        }
    }
    public function updateitem($itemId)
    {
        $item = itemModel::find($itemId);
        $itemkategori = DB::table('items')
            ->where('items.itemId', '=', $itemId)
            ->join('categoriesSparepart', 'categoriesSparepart.id', '=', 'items.kategori_id')
            ->select('items.*', 'categoriesSparepart.*')
            ->get();
        $kategori = DB::table('categoriesSparepart')
            ->select('categoriesSparepart.*')
            ->get();
        return view('dashboard.edititem', ['item' => $item, 'itemkategori' => $itemkategori, 'kategori' => $kategori]);
    }
    public function prosesupdateitem(Request $request, $itemId)
    {
        $item = \App\itemModel::find($itemId);
        $item->nama_item  = $request->nama_item;
        $item->kategori_id = $request->kategori_id;
        $item->description = $request->description;
        $item->type_product = $request->type_product;
        if ($request->hasFile('images')) {
            $request->file('images')->move('storage/shop/img/', $request->file('images')->getClientOriginalName());
            $item->images = $request->file('images')->getClientOriginalName();
            $item->save();
        } else {
            $item->save();
        }
        return redirect('/utility-item')->with('sukses', 'Itemnya berhasil diupdate. Coba cek ya..');
        // dd($item);
    }
    public function deleteitem($itemId)
    {
        $data_member = itemModel::find($itemId);

        if ($data_member) {
            if ($data_member->delete()) {

                DB::statement('ALTER TABLE items AUTO_INCREMENT = ' . (count(itemModel::all()) + 1) . ';');

                return back()->with('suksesitem', 'Data produk berhasil dihapus!');
            }
        }
    }
    public function updateuser($id)
    {
        $userfind = \App\User::find($id);
        return view('dashboard.edituser', ['userfind' => $userfind]);
    }
    public function prosesuser(Request $request, $id)
    {
        $user =  \App\User::find($id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->role = $request->role;
        $user->username = $request->username;
        $user->status = $request->status;
        $user->unpassword = $request->password;
        $user->logIP = $request->getClientIp();
        $user->updated_by = Auth()->user()->name;

        // dd($user);
        $user->save();
        return redirect('/user-config')->with('sukses', 'Data pengguna berhasil diperbarui. Coba cek ya..');
    }
    public function deleteuser($id)
    {
        $data_member = User::find($id);

        if ($data_member) {
            if ($data_member->delete()) {

                DB::statement('ALTER TABLE users AUTO_INCREMENT = ' . (count(User::all()) + 1) . ';');

                return back()->with('suser', 'Data pengguna berhasil dihapus dari database.');
            }
        }
    }
}
