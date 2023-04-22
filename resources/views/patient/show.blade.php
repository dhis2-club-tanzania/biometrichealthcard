<x-app-layout>
    <x-create-card>
        <x-slot name="title">
            Patient Information
        </x-slot>

            <div class="flex items-center justify-center">
                <p class="text-sm font-semibold text-gray-700 mr-3">Patient Number :</p>
                <h1 class="uppercase font-bold">{{$patient->id}}</h1>
            </div>
            <div class="flex items-center justify-center">
                <p class="text-sm font-semibold text-gray-700 mr-3">Patient name :</p>
                <p class="text-gray-500">{{$patient->name}}</p>
            </div>
            <div class="flex items-center justify-center">
                <p class="text-sm font-semibold text-gray-700 mr-3">Patient fingerprint ID :</p>
                <p class="text-gray-700">{{$patient->fingerprint_no}}</p>
            </div>
            <div class="flex items-center justify-center">
                <p class="text-sm font-semibold text-gray-700 mr-3">Patient status :</p>
                <p class="text-gray-700">{{$patient->status}}</p>
            </div>
            <div class="flex items-center justify-center mt-4">
                <x-primary-button onclick="history.back()">
                    CLOSE
                </x-primary-button>
            </div>

        </form>
    </x-create-card>
</x-app-layout>
