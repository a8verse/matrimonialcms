@extends('admin.layouts.blank')
@section('content')
    <div class="container pt-5">
        <div class="row">
            <div class="col-xl-6 mx-auto">
                <div class="card">
                    <div class="card-body">
                        <div class="mar-ver pad-btm text-center">
                            <h1 class="h3">Active Matrimonial CMS Update Process</h1>
                            <p>You will need to know the following items before
                            proceeding.</p>
                        </div>
                        <ol class="list-group">
                            <li class="list-group-item text-semibold"><i class="la la-check mr-2"></i>Codecanyon purchase code</li>
                            <li class="list-group-item text-semibold"><i class="la la-check mr-2"></i>Database Name</li>
                            <li class="list-group-item text-semibold"><i class="la la-check mr-2"></i>Database Username</li>
                            <li class="list-group-item text-semibold"><i class="la la-check mr-2"></i>Database Password</li>
                            <li class="list-group-item text-semibold"><i class="la la-check mr-2"></i>Database Hostname</li>
                        </ol>
                        <br>
                        <div class="text-center">

                         @if ($_SERVER['SERVER_NAME'] == 'localhost' || $_SERVER['SERVER_NAME'] == '127.0.0.1')
                            <a href="{{ route('update.step2') }}" class="btn btn-install text-uppercase">Update Now</a>
                        @else
                            <a href="{{ route('update.step1') }}" class="btn btn-install text-uppercase">Next Step</a>
                        @endif
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
