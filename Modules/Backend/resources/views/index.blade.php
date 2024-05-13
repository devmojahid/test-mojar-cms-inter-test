@extends('backend::layouts.master')

@section('content')
    <h1>Hello World</h1>

    <p>Module: {!! config('backend.name') !!}</p>
    @foreach ($plugins as $plugin)
        <p>{{ $plugin->get('name') }}</p>
        <p>{{ $plugin->isEnabled() == "true" ? "Activated":"Not Activate" }}</p>
    @endforeach



    {{-- activate the plugin --}}
    <form action="{{ route('backend.plugin.activate') }}" method="post">
        @csrf
        <input type="hidden" name="plugin" value="{{ $plugin->get('name') }}">
        <button type="submit">Activate Plugin 1</button>
    </form>

    {{-- deactivate the plugin --}}

    {{-- <form action="{{ route('backend.plugin.deactivate') }}" method="post">
        @csrf
        <input type="hidden" name="plugin" value="{{ $plugin->get('name') }}">
        <button type="submit">Deactivate Plugin 1</button>
    </form> --}}
@endsection
