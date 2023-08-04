@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <h1 class="text-black-50">Hello Admin , You are logged in!</h1>
    </div>
@endsection
@section('third_party_scripts')
<script type="text/javascript">
    if (window.location.hash && window.location.hash == '#_=_') {
        window.location.hash = '';
    }
</script>
@endsection