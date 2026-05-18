<section class="bg-white shadow rounded-xl p-6">

    <header class="mb-6">

        <h2 class="text-xl font-semibold text-gray-800">
            {{ __('Account Settings') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __("Update your profile information and contact details.") }}
        </p>

    </header>

    <form
        id="send-verification"
        method="post"
        action="{{ route('verification.send') }}"
    >
        @csrf
    </form>

    <form
        method="post"
        action="{{ route('admin.profile.update') }}"
        class="space-y-6"
    >

        @csrf
        @method('patch')

        {{-- Name --}}

        <div>

            <x-input-label
                for="name"
                :value="__('Name')"
            />

            <x-text-input
                id="name"
                name="name"
                type="text"
                class="mt-1 block w-full"
                :value="old('name', $user->name)"
                required
                autofocus
            />

            <x-input-error
                class="mt-2"
                :messages="$errors->get('name')"
            />

        </div>

        {{-- Email --}}

        <div>

            <x-input-label
                for="email"
                :value="__('Email')"
            />

            <x-text-input
                id="email"
                name="email"
                type="email"
                class="mt-1 block w-full"
                :value="old('email', $user->email)"
                required
            />

            <x-input-error
                class="mt-2"
                :messages="$errors->get('email')"
            />

        </div>

        {{-- Phone --}}

        <div>

            <x-input-label
                for="phone"
                :value="__('Phone Number')"
            />

            <x-text-input
                id="phone"
                name="phone"
                type="text"
                class="mt-1 block w-full"
                :value="old('phone', $user->phone)"
            />

            <x-input-error
                class="mt-2"
                :messages="$errors->get('phone')"
            />

        </div>

        {{-- Verification --}}

        @if (
            $user instanceof
            \Illuminate\Contracts\Auth\MustVerifyEmail
            && ! $user->hasVerifiedEmail()
        )

            <div>

                <p class="text-sm mt-2 text-gray-800">

                    {{ __('Your email address is unverified.') }}

                    <button
                        form="send-verification"
                        class="underline text-sm text-indigo-600 hover:text-indigo-800"
                    >

                        {{ __('Click here to re-send the verification email.') }}

                    </button>

                </p>

                @if (
                    session('status')
                    === 'verification-link-sent'
                )

                    <p class="mt-2 text-sm text-green-600">

                        {{ __('Verification link sent successfully.') }}

                    </p>

                @endif

            </div>

        @endif

        {{-- Submit --}}

        <div class="flex items-center gap-4">

            <x-primary-button>

                {{ __('Update Profile') }}

            </x-primary-button>

            @if (
                session('status')
                === 'profile-updated'
            )

                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-green-600"
                >

                    {{ __('Profile updated successfully.') }}

                </p>

            @endif

        </div>

    </form>

</section>