<x-app-layout>
    <div class="bg-gray-100 p-8 rounded-md w-full">
        @if(session('message'))
            <div class='alert alert-success alert-block'>
                    <strong>{{ session('message') }}</strong>
            </div>
        @endif
        <div class=" flex items-center justify-between pb-6">
            <div>
                <h2 class="text-gray-600 font-semibold text-l">FINGERPRINTS REPORT</h2>
            </div>
            <div>
                <span class="text-s text-gray-600 font-semibold text-l"> This report shows the number of fingerprints registered in NHIF over a specific week.</span>
            </div>
        </div>
        <div>
            <div class="chart-container" style="position: relative; height:40vh; width:70vw">
                <canvas id="fingerprintsChart"></canvas>
            </div>
            {{-- <div class="-mx-4 sm:-mx-8 px-4 sm:px-8 py-4 overflow-x-auto ">
                <div class="inline-block min-w-full shadow rounded-lg overflow-hidden">
                    <canvas id="myChart"  width="100" height="100" ></canvas>

                </div>
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
</x-app-layout>
