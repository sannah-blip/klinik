@extends('layouts.app')

@section('header_title', 'Pengaturan Profil')

@section('content')
<div class="max-w-4xl space-y-6">
    
    <div class="p-4 sm:p-8 bg-white border border-slate-200/60 shadow-sm rounded-2xl">
        <div class="max-w-xl">
            @include('profile.partials.update-profile-information-form')
        </div>
    </div>

    <div class="p-4 sm:p-8 bg-white border border-slate-200/60 shadow-sm rounded-2xl">
        <div class="max-w-xl">
            @include('profile.partials.update-password-form')
        </div>
    </div>

    <div class="p-4 sm:p-8 bg-white border border-slate-200/60 shadow-sm rounded-2xl">
        <div class="max-w-xl">
            @include('profile.partials.delete-user-form')
        </div>
    </div>

</div>
@endsection