@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                @livewire('admin-add-to-archive-list-form')
                @livewire('toarchivelist')

        </div>
    </div>
@endsection
