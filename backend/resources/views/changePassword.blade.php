{{-- Extends layout --}}
@extends('layouts.app')
{{-- Content --}}
@section('content')
<div class="container-fluid">
    <div class="row">
        <!-- left column -->
        <div class="col-md-12" style="margin: auto;">
            @if(session()->has('success'))
            <div class="alert alert-success cus-msg-cls" style="text-align: left;">
                {{ session()->get('success') }}
            </div>
            @elseif(session()->has('failure'))
            <div class="alert alert-danger cus-msg-cls" style="text-align: left;">
                {{ session()->get('failure') }}
            </div>
            @endif
            @if ($errors->any())
            <div class="alert alert-danger cus-msg-cls">
                <ul>
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif
            <!-- jquery validation -->
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Change Password</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form class="form-horizontal" method="POST" action="{{ route('change-password') }}">
                    <input name="_token" type="hidden" value="{{ csrf_token() }}"/>
                    <div class="card-body">
                        <div class="form-group row">
                            <div class="col-lg-6">
                                <label>Current Password:</label>
                                <input id="current-password" type="password" class="form-control" name="current-password">
                            </div>
                            <div class="col-lg-6">
                                <label>New Password:</label>
                                <input id="new-password" type="password" class="form-control" name="new-password">
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-lg-6">
                                <label>Confirm New Password:</label>
                                <input id="new-password-confirm" type="password" class="form-control" name="new-password_confirmation">
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-lg-6">
                                <button type="submit" class="btn btn-primary">Save</button>
                            </div>
                        </div>
                    </div>
                    <!-- /.card-body -->
                </form>
            </div>
            <!-- /.card -->
        </div>
        <!--/.col (left) -->
    </div>
</div>
@endsection
{{-- Scripts Section --}}
@section('third_party_scripts')
@endsection