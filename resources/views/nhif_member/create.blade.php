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

                    <x-text-input id="MobileNo" class="block mt-1 w-full" type="text" name="MobileNo" :value="old('MobileNo')" required />

                    <x-input-error :messages="$errors->get('MobileNo')" class="mt-2" />
                </div>

                <!-- Gender -->
                <div class="mt-3">
                    <x-input-label for="Gender" :value="__('Gender')" />

                    <x-text-input id="Gender" class="block mt-1 w-full" type="text" name="Gender" :value="old('Gender')" required />

                    <x-input-error :messages="$errors->get('Gender')" class="mt-2" />
                </div>

                 {{-- <!-- FormFourIndexNo -->
                <div>
                    <x-input-label for="FormFourIndexNo" :value="__('Form Four IndexNo')" />

                    <x-text-input id="FormFourIndexNo" class="block mt-1 w-full" type="text" name="plate_number" :value="old('FormFourIndexNo')" required autofocus />

                    <x-input-error :messages="$errors->get('FormFourIndexNo')" class="mt-2" />
                </div>

                <!-- MiddleName -->
               <div class="mt-4">
                   <x-input-label for="MiddleName" :value="__('Middle Name')" />

                   <x-text-input id="MiddleName" class="block mt-1 w-full" type="text" name="MiddleName" :value="old('MiddleName')" required autofocus />

                   <x-input-error :messages="$errors->get('MiddleName')" class="mt-2" />
               </div>

               <!-- AdmissionNo -->
               <div class="mt-4">
                <x-input-label for="AdmissionNo" :value="__('Admission No')" />

                <x-text-input id="AdmissionNo" class="block mt-1 w-full" type="text" name="AdmissionNo" :value="old('AdmissionNo')" required />

                <x-input-error :messages="$errors->get('AdmissionNo')" class="mt-2" />
            </div>

            <!-- CollageFaculty -->
            <div class="mt-4">
                <x-input-label for="CollageFaculty" :value="__('College Faculty')" />

                <x-text-input id="CollageFaculty" class="block mt-1 w-full" type="text" name="CollageFaculty" :value="old('CollageFaculty')" required />

                <x-input-error :messages="$errors->get('CollageFaculty')" class="mt-2" />
            </div>

            <!-- ProgrammeOfStudy -->
            <div class="mt-4">
                <x-input-label for="ProgrammeOfStudy" :value="__('Programme Of Study')" />

                <x-text-input id="ProgrammeOfStudy" class="block mt-1 w-full" type="text" name="ProgrammeOfStudy" :value="old('ProgrammeOfStudy')" required />

                <x-input-error :messages="$errors->get('ProgrammeOfStudy')" class="mt-2" />
            </div>

            <!-- CourseDuration -->
            <div class="mt-4">
                <x-input-label for="CourseDuration" :value="__('Course Duration')" />

                <x-text-input id="CourseDuration" class="block mt-1 w-full" type="text" name="CourseDuration" :value="old('CourseDuration')" required />

                <x-input-error :messages="$errors->get('CourseDuration')" class="mt-2" />
            </div>

            <!-- MaritalStatus -->
            <div class="mt-4">
                <x-input-label for="MaritalStatus" :value="__('Marital Status')" />

                <x-text-input id="MaritalStatus" class="block mt-1 w-full" type="text" name="MaritalStatus" :value="old('MaritalStatus')" required />

                <x-input-error :messages="$errors->get('MaritalStatus')" class="mt-2" />
            </div>

            <!-- DateJoiningEmployer -->
            <div class="mt-4">
                <x-input-label for="DateJoiningEmployer" :value="__('DateJoiningEmployer')" />

                <x-text-input id="DateJoiningEmployer" class="block mt-1 w-full" type="date" name="DateJoiningEmployer" :value="old('DateJoiningEmployer')" required />

                <x-input-error :messages="$errors->get('DateJoiningEmployer')" class="mt-2" />
            </div>

            <!-- DateOfBirth -->
            <div class="mt-4">
                <x-input-label for="DateOfBirth" :value="__('DateOfBirth')" />

                <x-text-input id="DateOfBirth" class="block mt-1 w-full" type="date" name="DateOfBirth" :value="old('DateOfBirth')" required />

                <x-input-error :messages="$errors->get('DateOfBirth')" class="mt-2" />
            </div>

            <!-- NationalID -->
            <div class="mt-4">
                <x-input-label for="NationalID" :value="__('National ID')" />

                <x-text-input id="NationalID" class="block mt-1 w-full" type="text" name="NationalID" :value="old('NationalID')" required />

                <x-input-error :messages="$errors->get('NationalID')" class="mt-2" />
            </div> --}}


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
