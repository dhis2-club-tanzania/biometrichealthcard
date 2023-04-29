<x-app-layout>
    <div class="bg-gray-100 p-4 rounded-md w-full">
        @if(session('message'))
            <div class='alert alert-success alert-block'>
                <button type="button" class="close" data-dismiss="alert">
                    <strong>{{ session('message') }}</strong>
                </button>
            </div>
        @endif
        <x-slot name="title">
            Member Information
        </x-slot>

        <div class="w-3/4 lg:w-1/2 mx-auto rounded-md bg-white shadow-lg m-10 p-10 text-center">
            <img
            class="w-48 lg:w-1/4 bg-blue-600 mx-auto rounded-lg mb-4 border-gray-800" alt="avatar"
            src="{{$nhifMember->image ? asset
                ('storage/' . $nhifMember->image) : asset('/images/nono.jpg')}}"
            alt=""
            />

            <h1 class="text-3xl">{{$nhifMember->FirstName}} {{$nhifMember->Surname}}</h1>
            <p class="text-gray-500 pb-4">{{$nhifMember->Gender}}</p>
            <div class="flex items-center justify-center">
                <p class="text-sm font-semibold text-gray-700 mr-3">Card No :</p>
                <p class="text-gray-500">{{$nhifMember->CardNo}}</p>
            </div>
            <div class="flex items-center justify-center">
                <p class="text-sm font-semibold text-gray-700 mr-3">Mobile No :</p>
                <p class="text-gray-700">{{$nhifMember->MobileNo}}</p>
            </div>
            <div class="flex items-center justify-center">
                <p class="text-sm font-semibold text-gray-700 mr-3">Fingerprint Status :</p>
                <p class="text-gray-700">{{$nhifMember->FingerprintStatus}}</p>
            </div>
            @if($nhifMember->FingerprintStatus == "TRUE")
                <div class="flex items-center justify-center">
                    <p class="text-sm font-semibold text-gray-700 mr-3">Fingerprint Number :</p>
                    <p class="text-gray-700">{{ $nhifMember->fingerprint->fingerprint_no }}</p>
                </div>
            @endif
            <div class="flex-container items-center justify-center mt-7">
                @if (!$nhifMember->fingerprint)
                    <a href="{{ route('nhifMember.details.create', ['nhifMember' => $nhifMember]) }}">
                        <button type="button" class="mr-20 inline-flex items-center px-4 py-2 bg-green-700 border border-transparent rounded-md font-bold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            Register Fingerprint
                        </button>
                    </a>
                @endif

                <x-primary-button class="bg-red-700 font-bold" onclick="history.back()">
                    CLOSE
                </x-primary-button>
            </div>
</x-app-layout>
