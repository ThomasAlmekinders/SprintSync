@extends('layouts.app')

@section('content')
<div class="container-xxl py-4">
    <div class="row justify-content-center">
        <div class="col-12 col-lg-10 col-xl-8">
            <div class="card">
                <div class="card-header">{{ __('Beheer') }}</div>

                <div class="card-body">
                    @include('account.beheer.layouts.navtabs')
                    @yield('beheer-content')
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
