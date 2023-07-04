<x-app-layout>
    <div class="bg-gray-100 p-8 rounded-md w-full">
        @if(session('message'))
            <div class='alert alert-success alert-block'>
                    <strong>{{ session('message') }}</strong>
            </div>
        @endif

        <div class=" flex items-center justify-end">
            <div class="flex">
                <h2 class="text-blue font-semibold text-l"  onclick="printPage()">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-printer" viewBox="0 0 16 16">
                        <path d="M2.5 8a.5.5 0 1 0 0-1 .5.5 0 0 0 0 1z"/>
                        <path d="M5 1a2 2 0 0 0-2 2v2H2a2 2 0 0 0-2 2v3a2 2 0 0 0 2 2h1v1a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2v-1h1a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2h-1V3a2 2 0 0 0-2-2H5zM4 3a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1v2H4V3zm1 5a2 2 0 0 0-2 2v1H2a1 1 0 0 1-1-1V7a1 1 0 0 1 1-1h12a1 1 0 0 1 1 1v3a1 1 0 0 1-1 1h-1v-1a2 2 0 0 0-2-2H5zm7 2v3a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1v-3a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1z"/>
                        </svg>
                </h2>
                <h2 class="text-blue font-semibold text-l"  onclick="printPage()">  PRINT</h2>
            </div>
        </div>
        <!-- Logo -->
        <div class="shrink-0 flex items-center justify-center">
            <a href="{{ route('dashboard') }}">
                <x-application-logo class="block h-10 w-auto fill-current text-gray-600" />
            </a>
        </div>
        <div class="shrink-0 flex items-center justify-center p-4">
            <p>NHIF BIOMETRIC AUTHENTICATION SYSTEM</p>
        </div>
        <div class="shrink-0 flex flex-col items-center justify-center">
            <p>This report shows the member of NHIF whose fingerprints have been registered
            </p>
        </div>

        <div class=" flex items-center justify-center p-2">
            <div class="flex flex-col px-5">
            <table class="min-w-full leading-normal">
                <thead>
                    <tr>
                        <th
                            class="px-5 py-3 border-b-2 border-gray-200 bg-gray-800 text-left text-xs font-semibold text-gray-200 uppercase tracking-wider">
                            Fingerprint NO.
                        </th>
                        <th
                            class="px-5 py-3 border-b-2 border-gray-200 bg-gray-800 text-left text-xs font-semibold text-gray-200 uppercase tracking-wider">
                            Member
                        </th>
                        <th
                            class="px-5 py-3 border-b-2 border-gray-200 bg-gray-800 text-left text-xs font-semibold text-gray-200 uppercase tracking-wider">
                            Member ID
                        </th>
                        <th
                            class="px-5 py-3 border-b-2 border-gray-200 bg-gray-800 text-left text-xs font-semibold text-gray-200 uppercase tracking-wider">
                            Fingerprint Status
                        </th>
                    </tr>
                </thead>
                @foreach ($fingerprints as $fingerprint)
                <tbody>
                    <tr>
                        <td class="px-5 py-3 border-b border-gray-200 bg-white text-sm">
                            <p class="text-gray-900 whitespace-no-wrap">
                                {{$fingerprint->fingerprint_no}}
                            </p>
                        </td>
                        <td class="px-5 py-3 border-b border-gray-200 bg-white text-sm">
                            <p class="text-gray-900 whitespace-no-wrap">{{$fingerprint->nhif_member->FirstName}} {{$fingerprint->nhif_member->Surname}}</p>
                        </td>
                        <td class="px-5 py-3 border-b border-gray-200 bg-white text-sm">
                            <p class="text-gray-900 whitespace-no-wrap">{{$fingerprint->nhif_member->id}}</p>
                        </td>
                        <td class="px-5 py-3 border-b border-gray-200 bg-white text-sm">
                            <p class="text-gray-900 whitespace-no-wrap">
                                {{$fingerprint->fingerprint_status}}
                            </p>
                        </td>
                    </tr>
                </tbody>
                @endforeach
                TOTAL REGISTERED = {{$fingerprintcount}}
            </table>


            {{-- <div class="chart-container" style="position: relative; height:40vh; width:70vw">
                <canvas id="fingerprintsChart"></canvas>
            </div> --}}
        </div>
	</div>
    <script>
        var ctx = document.getElementById('fingerprintsChart').getContext('2d');
        var fingerprintsChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: {!! $fingerprintsByWeek->pluck('week') !!},
                datasets: [{
                    label: '# of New Fingerprints',
                    data: {!! $fingerprintsByWeek->pluck('count') !!},
                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                }
            }
        });
    </script>
    <script>
        function printPage() {
            window.print();
        }
    </script>
</x-app-layout>
