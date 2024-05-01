@extends('layouts.layout')
@section('content')
    <span class="text-sm border border-gray-300 inline-block breadcrumbs bg-white px-8 py-3 poppins-medium rounded-full">
        <ul>
            <li><a href="/dashboard">dashboard</a></li>
            <li><a href="#">Edit Visi Misi</li></a>
        </ul>
    </span>

    @if (session('error'))
        <div role="alert" class="alert alert-error mb-8 text-white">
            <span>{{ session('error') }}</span>
        </div>
    @endif

    @if (session('success'))
        <div role="alert" class="alert alert-success mb-8 text-white">
            <span>{{ session('success') }}</span>
        </div>
    @endif

    <div class="flex justify-center mt-10 mb-10">
        <livewire:visi />
    </div>

    <div class="flex justify-center mb-10">
        <livewire:misi />
    </div>
@endsection
