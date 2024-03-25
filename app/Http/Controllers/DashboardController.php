<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Siswa;
use App\Helper\menu;

use Session;
use DB;


class DashboardController extends Controller
{
    function dashboard(Request $request){
        if (!$request->tahun){
        $menu = menu::getMenu(Session::get('role'));

         return view('page.dashboard',compact('menu'));
    }
        $menu = menu::getMenu(Session::get('role'));
        $siswa = count(Siswa::all());
        $transaksi = TransaksiHead::select( DB::raw('sum(masuk) as pemasukan ,sum(keluar) as pengeluaran'))->where(DB::raw('MONTH(tanggal)'),DB::raw('MONTH(now())'))->first();
        $pengeluaran = TransaksiHead:: select( DB::raw('sum(keluar) as pengeluaran'))->groupBy(DB::raw('MONTH(tanggal)'))->orderBy(DB::raw('MONTH(tanggal)'),'asc')->where(DB::raw('Year(tanggal)'),$request->tahun)->get();
        $pemasukan = TransaksiHead:: select( DB::raw('sum(masuk) as pemasukan'))->groupBy(DB::raw('MONTH(tanggal)'))->orderBy(DB::raw('MONTH(tanggal)'),'asc')->where(DB::raw('Year(tanggal)'),$request->tahun)->get();
        $pengeluaranTahun = TransaksiHead:: select( DB::raw('sum(keluar) as pengeluaran'))->where(DB::raw('year(tanggal)'),$request->tahun)->first();
        $pemasukanTahun = TransaksiHead:: select( DB::raw('sum(masuk) as pemasukan'))->where(DB::raw('year(tanggal)'),$request->tahun)->first();
        $bulan = TransaksiHead::select(  DB::raw('MONTHNAME(tanggal) as bulan'))->distinct()->orderBy(DB::raw('MONTH(tanggal)'),'asc')->get();
        $tahun = TransaksiHead::select(  DB::raw('YEAR(tanggal) as tahun'))->distinct()->get();
        $keluar =  collect($pengeluaran)->pluck('pengeluaran')->toArray();
        $bulan = collect($bulan)->pluck('bulan')->toArray();
        $masuk =  collect($pemasukan)->pluck('pemasukan')->toArray();
        // return $pengeluaran;
        return view('page.dashboard',compact(['menu','siswa','transaksi','pemasukanTahun','pengeluaranTahun','keluar','masuk','bulan','tahun','request']));
    
    

    }
}
