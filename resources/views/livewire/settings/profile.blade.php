<section class="w-full">
    @include('partials.settings-heading')

    <flux:heading class="sr-only">{{ __('Profile Settings') }}</flux:heading>

    <x-settings.layout :heading="__('Profile')" :subheading="__('Update your name and email address')">
        <form wire:submit="updateProfileInformation" class="my-6 w-full space-y-6">
            <flux:input wire:model="name" :label="__('Name')" type="text" required autofocus autocomplete="name" />
            <flux:input wire:model="role" :label="__('Role')" type="text" disabled />
            <div>
                <flux:input wire:model="email" :label="__('Email')" type="email" required autocomplete="email" />

                @if ($this->hasUnverifiedEmail)
                <div>
                    <flux:text class="mt-4">
                        {{ __('Your email address is unverified.') }}

                        <flux:link class="text-sm cursor-pointer" wire:click.prevent="resendVerificationNotification">
                            {{ __('Click here to re-send the verification email.') }}
                        </flux:link>
                    </flux:text>

                    @if (session('status') === 'verification-link-sent')
                    <flux:text class="mt-2 font-medium !dark:text-green-400 !text-green-600">
                        {{ __('A new verification link has been sent to your email address.') }}
                    </flux:text>
                    @endif
                </div>
                @endif
            </div>

            <div class="flex items-center gap-4">
                <div class="flex items-center justify-end">
                    <flux:button variant="primary" type="submit" class="w-full">{{ __('Save') }}</flux:button>
                </div>

                <x-action-message class="me-3" on="profile-updated">
                    {{ __('Saved.') }}
                </x-action-message>
            </div>
        </form>

        {{-- Alumni Profile Section --}}
        @if ($this->isAlumni && $alumniProfile)
        <div class="mt-8 border-t border-zinc-200 dark:border-zinc-700 pt-6">
            <flux:heading size="lg" class="mb-4">{{ __('Data Alumni') }}</flux:heading>
            <flux:text class="mb-6 text-zinc-500 dark:text-zinc-400">{{ __('Informasi profil alumni Anda') }}</flux:text>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="space-y-1">
                    <flux:label>{{ __('NIM') }}</flux:label>
                    <flux:text class="font-medium">{{ $alumniProfile->nim ?? '-' }}</flux:text>
                </div>

                <div class="space-y-1">
                    <flux:label>{{ __('Nama Lengkap') }}</flux:label>
                    <flux:text class="font-medium">{{ $alumniProfile->nama_lengkap ?? '-' }}</flux:text>
                </div>

                <div class="space-y-1">
                    <flux:label>{{ __('Program Studi') }}</flux:label>
                    <flux:text class="font-medium">{{ $alumniProfile->prodi ?? '-' }}</flux:text>
                </div>

                <div class="space-y-1">
                    <flux:label>{{ __('Tahun Lulus') }}</flux:label>
                    <flux:text class="font-medium">{{ $alumniProfile->tahun_lulus ?? '-' }}</flux:text>
                </div>

                <div class="space-y-1">
                    <flux:label>{{ __('No. HP') }}</flux:label>
                    <flux:text class="font-medium">{{ $alumniProfile->no_hp ?? '-' }}</flux:text>
                </div>

                <div class="space-y-1 md:col-span-2">
                    <flux:label>{{ __('Alamat') }}</flux:label>
                    <flux:text class="font-medium">{{ $alumniProfile->alamat ?? '-' }}</flux:text>
                </div>
            </div>
        </div>
        @elseif ($this->isAlumni && !$alumniProfile)
        <div class="mt-8 border-t border-zinc-200 dark:border-zinc-700 pt-6">
            <flux:heading size="lg" class="mb-4">{{ __('Data Alumni') }}</flux:heading>
            <flux:text class="text-zinc-500 dark:text-zinc-400">
                {{ __('Data profil alumni belum tersedia. Silakan hubungi administrator untuk melengkapi data Anda.') }}
            </flux:text>
        </div>
        @endif

        @if ($this->showDeleteUser)
        <livewire:settings.delete-user-form />
        @endif
    </x-settings.layout>

</section>

