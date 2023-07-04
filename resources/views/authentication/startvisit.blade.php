<x-app-layout>
    <x-create-card>
        <x-slot name="title">
           NHIF Members Registration
        </x-slot>

        <form method="POST" action="{{ route('nhifmembers.store') }}" enctype="multipart/form-data">
            @csrf

                <!-- patient -->
                <div class="mt-3">
                    <x-input-label for="patient" :value="__('patient')" />

                    <x-text-input id="patient" class="block mt-1 w-full" type="text" name="patient" :value="old('patient')" required />

                    <x-input-error :messages="$errors->get('patient')" class="mt-2" />
                </div>

                <!-- visitType -->
               <div class="mt-3">
                
                <x-input-label for="visitType" :value="__('visitType')" />

                <select name="visitType">
                    @foreach ($visitTypes['results'] as $visitType)
                        <option value="{{ $visitType['uuid'] }}">{{ $visitType['display'] }}</option>
                    @endforeach
                </select>

                <x-input-error :messages="$errors->get('visitType')" class="mt-2" />
                </div>

                <!-- CardNo -->
                <div class="mt-3">
                    <x-input-label for="CardNo" :value="__('Card No')" />

                    <x-text-input id="CardNo" class="block mt-1 w-full" type="text" name="CardNo" :value="old('CardNo')" required />

                    <x-input-error :messages="$errors->get('CardNo')" class="mt-2" />
                </div>

                {{-- <!-- Gender -->
                <div class="mt-3">
                    <x-input-label for="Gender" :value="__('Gender')" />

                    <select name="Gender" id="Gender" required>
                        <option value="male" {{ old('Gender') == 'male' ? 'selected' : '' }}>Male</option>
                        <option value="female" {{ old('Gender') == 'female' ? 'selected' : '' }}>Female</option>
                        <option value="other" {{ old('Gender') == 'other' ? 'selected' : '' }}>Other</option>
                    </select>

                    <x-input-error :messages="$errors->get('Gender')" class="mt-2" />
                </div> --}}

            <div class="flex-container items-center justify-center mt-4">
                <x-primary-button class="mx-20 p-2 bg-green-600 w-30">
                    {{ __('START') }}
                </x-primary-button>
                <x-primary-button class="p-2 mx-20 bg-red-600 w-30" onclick="history.back()">
                    CLOSE
                </x-primary-button>
            </div>
        </form>
    </x-create-card>
</x-app-layout>
