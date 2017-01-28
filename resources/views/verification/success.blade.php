@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Account verification</div>

                <div class="panel-body">
                    Congratulations {{ $username }}, your account associated with {{ $email }} has been verified. Join your friends on {{ config('app.name') }} now! 
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
