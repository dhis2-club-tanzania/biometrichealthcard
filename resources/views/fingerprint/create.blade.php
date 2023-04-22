<x-app-layout>
    <x-create-card>
        <x-slot name="title">
           NHIF Members Registration
        </x-slot>

        <form method="POST" action="{{ route('fingerprints.store') }}">
            @csrf

                <!-- member_id -->
                <div class="mt-3">
                    <x-input-label for="member_id" :value="__('NHIF Member ID')" />

                    <input type="text" name="member_id" value="{{ $nhifMember->id }}" readonly>

                    {{-- <x-text-input id="member_id" class="block mt-1 w-full" type="hidden" name="member_id" :value="{{ $nhifMember->id }}" required /> --}}

                    <x-input-error :messages="$errors->get('member_id')" class="mt-2" />
                </div>

                <!-- Fingerprint No. -->
                <div class="mt-3">
                    <x-input-label for="fingerprint_no" :value="__('Fingerprint No.')" />

                    <input type="text" name="fingerprint_no" id="fingerprint_no" readonly>

                    <x-input-error :messages="$errors->get('fingerprint_no')" class="mt-2" />
                </div>


            <div class="flex-container items-center justify-center mt-4">
                <x-primary-button type="submit" class="btn btn-success" onclick="generateRandomNumber()">
                    Generate ID
                </x-primary-button>
                <x-primary-button class="p-2 bg-green-600 w-30">
                    {{ __('Register') }}
                </x-primary-button>
                <x-primary-button class="p-2 mx-20 bg-red-600 w-30" onclick="history.back()">
                    CLOSE
                </x-primary-button>
            </div>
        </form>
    </x-create-card>

    <script>
        function generateRandomNumber() {
            event.preventDefault();
            fetch('{{ route("generateFingerprintId") }}', {
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                })
                .then(response => response.json())
                .then(data => {
                    document.getElementById('fingerprint_no').value = data.fingerprint_no;
                    console.log('me');
                })
                .catch(error => console.error(error));
        }
        </script>
</x-app-layout>
