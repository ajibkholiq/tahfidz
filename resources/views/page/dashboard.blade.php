@extends('layout.master')
@section('main')
@php $warna = ['navy','lazur','yellow','red'] @endphp
<div class="row">
@foreach ($menu as $key => $sm)
@if ($sm->route != "" || $sm->induk != 'head')
    <div class="col-lg-4">
        <div class="widget {{$key < 4 ? $warna[$key] : ($key < 8 ? $warna[$key-4] : $warna[$key-8])}}-bg p-lg text-center">
            <div class="m-b-md">
                <h3 class="font-bold no-margins">
                 <a href="/{{ $sm->route }}" class="text-capitalize text-white">{{ $sm->nama_menu }}</a>
                </h3>
            </div>
        </div>
    </div>
@endif
@endforeach
<div style="margin-bottom: 100px"></div>
</div>
@endsection
@push('js')
@endpush
