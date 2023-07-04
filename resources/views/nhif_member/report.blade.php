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
        <div class="shrink-0 flex items-center justify-center">
            <p>This report shows the number of NHIF members registered over a specific period of time.
            </p>
        </div>

        <div class=" flex items-center justify-center pb-2">
            <div class="flex items-center justify-between px-6">
            <div class=" flex flex-col ">
                <h2 class="text-black font-semibold text-l">Number of members registered on speific dates</h2>
                @foreach ($datas as $data)
                    <h2 class="text-green font-semibold text-l">{{ $data->date}}={{$data->count}} members</h2>
                @endforeach
            </div>
            <div class=" flex items-center justify-between p-6">
                <div class=" flex flex-col ">
                    <h2 class="text-black font-semibold text-l">Total Members Registered according to Gender</h2>
                    <h2 class="text-red font-semibold text-l">MALE = {{$male}} </h2>
                <h2 class="text-red font-semibold text-l">FEMALE = {{$female}}</h2>
                </div>
            </div>
            </div>
            {{-- <div class="chart-container justify-between" style="position: relative; height:30vh; width:40vw">
                <canvas id="myChart"></canvas>
            </div> --}}
        </div>

        <table class="min-w-full leading-normal">
            <thead>
                <tr>
                    <th
                        class="px-5 py-3 border-b-2 border-gray-200 bg-gray-800 text-left text-xs font-semibold text-gray-200 uppercase tracking-wider">
                        S/N
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
                        Gender
                    </th>
                    <th
                        class="px-5 py-3 border-b-2 border-gray-200 bg-gray-800 text-left text-xs font-semibold text-gray-200 uppercase tracking-wider">
                        REGISTERED
                    </th>
                </tr>
            </thead>
            @foreach ($members as $member)
            <tbody>
                <tr>
                    <td class="px-5 py-3 border-b border-gray-200 bg-white text-sm">
                        <p class="text-gray-900 whitespace-no-wrap">
                            {{$member->id}}
                        </p>
                    </td>
                    <td class="px-5 py-3 border-b border-gray-200 bg-white text-sm">
                        <p class="text-gray-900 whitespace-no-wrap">{{$member->FirstName}} {{$member->Surname}}</p>
                    </td>
                    <td class="px-5 py-3 border-b border-gray-200 bg-white text-sm">
                        <p class="text-gray-900 whitespace-no-wrap">{{$member->id}}</p>
                    </td><td class="px-5 py-3 border-b border-gray-200 bg-white text-sm">
                        <p class="text-gray-900 whitespace-no-wrap uppercase">{{$member->Gender}}</p>
                    </td>
                    <td class="px-5 py-3 border-b border-gray-200 bg-white text-sm">
                        <p class="text-gray-900 whitespace-no-wrap">
                            {{$member->created_at}}
                        </p>
                    </td>
                </tr>
            </tbody>
            @endforeach
        </table>
	</div>

    <script>
        var ctx = document.getElementById('myChart').getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'bar',
            data: {!! json_encode($dataArray) !!},
            options: {
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
