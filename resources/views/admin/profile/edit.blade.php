@extends('adminlte::page')

@section('title', 'Account Settings')

@section('content')

<div class="row">

    <div class="col-md-8 offset-md-2">

        {{-- Profile Information --}}

        <div class="card">

            <div class="card-header">

                <h3 class="card-title">
                    Account Settings
                </h3>

            </div>

            <form
                method="POST"
                action="{{ route('admin.profile.update') }}"
            >

                @csrf
                @method('PATCH')

                <div class="card-body">

                    {{-- Name --}}

                    <div class="form-group">

                        <label>Name</label>

                        <input
                            type="text"
                            name="name"
                            class="form-control"
                            value="{{ old('name', $user->name) }}"
                        >

                        @error('name')

                            <small class="text-danger">
                                {{ $message }}
                            </small>

                        @enderror

                    </div>

                    {{-- Email --}}

                    <div class="form-group">

                        <label>Email</label>

                        <input
                            type="email"
                            name="email"
                            class="form-control"
                            value="{{ old('email', $user->email) }}"
                        >

                        @error('email')

                            <small class="text-danger">
                                {{ $message }}
                            </small>

                        @enderror

                    </div>

                    {{-- Phone --}}

                    <div class="form-group">

                        <label>Phone</label>

                        <input
                            type="text"
                            name="phone"
                            class="form-control"
                            value="{{ old('phone', $user->phone) }}"
                        >

                        @error('phone')

                            <small class="text-danger">
                                {{ $message }}
                            </small>

                        @enderror

                    </div>

                </div>

                <div class="card-footer">

                    <button
                        type="submit"
                        class="btn btn-primary"
                    >

                        Update Profile

                    </button>

                </div>

            </form>

        </div>

        {{-- Change Password --}}

        <div class="card mt-4">

            <div class="card-header">

                <h3 class="card-title">
                    Change Password
                </h3>

            </div>

            @if(session('success'))

				<div class="alert alert-success">

					{{ session('success') }}

				</div>

			@endif

            <form  method="POST"  action="{{ route('admin.password.update') }}">

                @csrf
				@method('PUT')

                <div class="card-body">

                    {{-- Current Password --}}

                    <div class="form-group">

                        <label>Current Password</label>

                        <input
                            type="password"
                            name="current_password"
                            class="form-control"
                        >

                        @error('current_password')

							<small class="text-danger">
								{{ $message }}
							</small>

						@enderror

                    </div>

                    {{-- New Password --}}

                    <div class="form-group">

                        <label>New Password</label>

                        <input
                            type="password"
                            name="password"
                            class="form-control"
                        >

                        @error('password')

                            <small class="text-danger">
                                {{ $message }}
                            </small>

                        @enderror

                    </div>

                    {{-- Confirm Password --}}

                    <div class="form-group">

                        <label>Confirm Password</label>

                        <input
                            type="password"
                            name="password_confirmation"
                            class="form-control"
                        >

                    </div>

                </div>

                <div class="card-footer">

                    <button
                        type="submit"
                        class="btn btn-success"
                    >

                        Update Password

                    </button>

                </div>

            </form>

        </div>

    </div>

</div>

@stop