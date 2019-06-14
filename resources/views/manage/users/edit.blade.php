@extends('layouts.manage')

@section('content')
    <div class="flex-container">
        <div class="columns m-t-10">
            <div class="column">
                <h1 class="title">Edit User</h1>
            </div>
        </div>
        <hr class="m-t-0">

        <form action="{{route('users.update', $user->id)}}" method="POST">
            {{method_field('PUT')}}
            {{csrf_field()}}
            <div class="columns">
                <div class="column">
                    <div class="field">
                        <label for="first_name" class="label">Firstname:</label>
                        <p class="control">
                            <input type="text" class="input" name="first_name" id="first_name"
                                   value="{{$user->first_name}}">
                        </p>
                    </div>

                    <div class="field">
                        <label for="last_name" class="label">Lastname:</label>
                        <p class="control">
                            <input type="text" class="input" name="last_name" id="last_name"
                                   value="{{$user->last_name}}">
                        </p>
                    </div>

                    <div class="field">
                        <label for="email" class="label">Email:</label>
                        <p class="control">
                            <input type="text" class="input" name="email" id="email" value="{{$user->email}}">
                        </p>
                    </div>

                    <changeuserpassword></changeuserpassword>
                    <imgupload></imgupload>

                </div> <!-- end of .column -->
            </div>
            <div class="columns">
                <div class="column">
                    <hr/>
                    <button class="button is-link is-pulled-right" style="width: 250px;">Update User</button>
                </div>
            </div>
        </form>

    </div> <!-- end of .flex-container -->
@endsection