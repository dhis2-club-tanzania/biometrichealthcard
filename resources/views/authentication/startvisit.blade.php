<x-app-layout>
    <x-create-card>
        <x-slot name="title">
           NHIF Members Registration
        </x-slot>

        <form method="POST" action="{{ route('nhifmembers.store') }}" enctype="multipart/form-data">
            @csrf

                <!-- Image -->
                <div>
                    <x-input-label for="image" :value="__('Image')"> Select Image </x-input-label>

                    <x-text-input id="image" class="block mt-1 w-full" type="file" name="image" :value="old('image')" required />

                    <x-input-error :messages="$errors->get('image')" class="mt-2" />
                </div>

                <!-- FirstName -->
                <div class="mt-3">
                    <x-input-label for="FirstName" :value="__('First Name')" />

                    <x-text-input id="FirstName" class="block mt-1 w-full" type="text" name="FirstName" :value="old('FirstName')" required />

                    <x-input-error :messages="$errors->get('FirstName')" class="mt-2" />
                </div>

                <!-- Surname -->
               <div class="mt-3">
                    <x-input-label for="Surname" :value="__('Surname')" />

                    <x-text-input id="Surname" class="block mt-1 w-full" type="text" name="Surname" :value="old('Surname')" required />

                    <x-input-error :messages="$errors->get('Surname')" class="mt-2" />
                </div>

                <!-- CardNo -->
                <div class="mt-3">
                    <x-input-label for="CardNo" :value="__('Card No')" />

                    <x-text-input id="CardNo" class="block mt-1 w-full" type="text" name="CardNo" :value="old('CardNo')" required />

                    <x-input-error :messages="$errors->get('CardNo')" class="mt-2" />
                </div>

                <!-- MobileNo -->
                <div class="mt-3">
                    <x-input-label for="MobileNo" :value="__('Mobile No')" />

                    <x-text-input id="MobileNo" class="block mt-1 w-full" type="text" name="MobileNo" placeholder="0*********" :value="old('MobileNo')" required />

                    <x-input-error :messages="$errors->get('MobileNo')" class="mt-2" />
                </div>

                <!-- Gender -->
                <div class="mt-3">
                    <x-input-label for="Gender" :value="__('Gender')" />

                    <select name="Gender" id="Gender" required>
                        <option value="male" {{ old('Gender') == 'male' ? 'selected' : '' }}>Male</option>
                        <option value="female" {{ old('Gender') == 'female' ? 'selected' : '' }}>Female</option>
                        <option value="other" {{ old('Gender') == 'other' ? 'selected' : '' }}>Other</option>
                    </select>

                    <x-input-error :messages="$errors->get('Gender')" class="mt-2" />
                </div>

            <div class="flex-container items-center justify-center mt-4">
                <x-primary-button class="mx-20 p-2 bg-green-600 w-30">
                    {{ __('Register') }}
                </x-primary-button>
                <x-primary-button class="p-2 mx-20 bg-red-600 w-30" onclick="history.back()">
                    CLOSE
                </x-primary-button>
            </div>
        </form>
    </x-create-card>
</x-app-layout>
