@extends('layouts.app')

@section('content')
<div class="container mx-auto py-8">
    <h1 class="text-3xl font-bold mb-6 text-center">Gestión de Productos</h1>
    <div class="bg-white shadow rounded-lg p-6">
        <livewire:product-list />
    </div>
</div>
@endsection
