<x-app-layout>
    <link rel="stylesheet"
    href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
    integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm"
    crossorigin="anonymous">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('PATIENT MANAGEMENT') }}
        </h2>
    </x-slot>
    @if(session('message'))
        <div class='alert alert-success alert-block'>
            <button type="button" class="close" data-dismiss="alert">
                <strong>{{ session('message') }}</strong>
            </button>
        </div>
    @endif
    <div class=" flex items-center justify-between py-2 px-8">
        <div>
			<h2 class="text-gray-600 font-semibold">Authorized Patients</h2>
			<span class="text-xs">All patients details</span>
		</div>
		<div class="flex items-center justify-between">
			<div class="flex bg-gray-100 items-center p-2 rounded-md">
				<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" viewBox="0 0 20 20"
					fill="currentColor">
					<path fill-rule="evenodd"
						d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
						clip-rule="evenodd" />
				</svg>
				<input class="bg-white outline-none ml-1 block " type="text" name="" id="" placeholder="search...">
            </div>
				<div class="lg:ml-40 ml-10 space-x-8">
                    <a href="">
					    <button class="bg-gray-700 px-4 py-2 rounded-md text-gray-50 font-semibold tracking-wide cursor-pointer">Report</button>
                    </a>
                        <button class="bg-gray-700 px-4 py-2 rounded-md text-gray-50 font-semibold tracking-wide cursor-pointer" type="button" data-toggle="modal" data-target="#registerModal">Register Fingerprint</button>
                        <form method="post" action="#">
                        <div class="modal fade" id="registerModal" tabindex="-1" role="dialog"  aria-hidden="true" data-backdrop="static">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Register Patient's Fingerprint</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-
                                            label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                    </div>
                                    {{-- modal body --}}
                                    <form>
                                        @csrf
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="form-group col-md-8">
                                              <label for="Name">Full Name:</label>
                                              <div>
                                                <form>
                                                    <input type="text" id="search-input" name="search" placeholder="Search...">
                                                </form>
                                                <ol id="search-results"></ol>
                                            </div>
                                            </div>
                                          </div>
                                          {{-- <input type="text" onchange="showResult(this)"> --}}
                                          <div class="row">
                                              <div class="form-group col-md-8">
                                                <label for="Club">Fingerprint ID:</label>
                                                <div>
                                                <input type="text" name="fingerprint_no" id="fingerprint_no" readonly>
                                                </div>
                                              </div>
                                          </div>
                                    </div>
                                    <div class="modal-footer">
                                            <button type="submit" class="btn btn-success" onclick="generateRandomNumber()">Generate ID</button>
                                            <button type="button" id="savedb" class="btn btn-primary">Save Changes</button>
                                    </div>
                                </form>
                                    {{-- moddle end --}}
                                </div>
                            </div>
                        </div>
                        </form>
                </div>
			</div>
		</div>
    <div class="py-2">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="flex flex-wrap">
                    <div class="w-full p-4">
                        <h2 class="text-2xl font-bold mb-4">Table</h2>
                        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                          <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                              <tr>
                                  <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-800 ">
                                      <div class="flex items-center">
                                          <input id="checkbox-table-1" type="checkbox" class="w-4 h-4 bg-gray-800 rounded border-white focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                          <label for="checkbox-table-1" class="sr-only">checkbox</label>
                                      </div>
                                  </th>
                                  <th
                                      class="px-5 py-3 border-b-2 border-gray-200 bg-gray-800 text-left text-xs font-semibold text-gray-200 uppercase tracking-wider">
                                      Patient ID
                                  </th>
                                  <th
                                      class="px-5 py-3 border-b-2 border-gray-200 bg-gray-800 text-left text-xs font-semibold text-gray-200 uppercase tracking-wider">
                                      Name
                                  </th>
                                  <th
                                      class="px-5 py-3 border-b-2 border-gray-200 bg-gray-800 text-left text-xs font-semibold text-gray-200 uppercase tracking-wider">
                                      Fingerprint No.
                                  </th>
                                  <th
                                      class="px-5 py-3 border-b-2 border-gray-200 bg-gray-800 text-left text-xs font-semibold text-gray-200 uppercase tracking-wider">
                                      Status
                                  </th>
                                  <th
                                      class="px-5 py-3 border-b-2 border-gray-200 bg-gray-800 text-left text-xs font-semibold text-gray-200 uppercase tracking-wider">
                                      action
                                  </th>
                              </tr>
                          </thead>
                          @foreach ($patients as $patient)
                          <tbody>
                              <tr>
                                  <td class="px-5 py-3 border-b border-gray-200 bg-white">
                                      <div class="flex items-center">
                                          <input id="checkbox-table-1" type="checkbox" class="w-4 h-4 text-gray-900 bg-white rounded border-gray-900 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                          <label for="checkbox-table-1" class="sr-only">checkbox</label>
                                      </div>
                                  </td>
                                  <td class="px-5 py-3 border-b border-gray-200 bg-white text-sm">
                                      <p class="text-gray-900 whitespace-no-wrap">
                                          {{$patient->id}}
                                      </p>
                                  </td>
                                  <td class="px-5 py-3 border-b border-gray-200 bg-white text-sm">
                                      <p class="text-gray-900 whitespace-no-wrap">{{$patient->name}}</p>
                                  </td>
                                  <td class="px-5 py-3 border-b border-gray-200 bg-white text-sm">
                                      <p class="text-gray-900 whitespace-no-wrap">
                                          {{$patient->fingerprint_no}}
                                      </p>
                                  </td>
                                  <td class="px-5 py-3 border-b border-gray-200 bg-white text-sm">
                                    <p class="text-gray-900 whitespace-no-wrap">
                                        {{$patient->status}}
                                    </p>
                                </td>
                                  {{-- <td class="flex px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                      <a href="{{ route('clients.show',$client->id) }}">
                                          <span class="relative inline-block px-2 py-1 font-semibold text-green-600 leading-tight">
                                              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
                                                  <path d="M10 12.5a2.5 2.5 0 100-5 2.5 2.5 0 000 5z" />
                                                  <path fill-rule="evenodd" d="M.664 10.59a1.651 1.651 0 010-1.186A10.004 10.004 0 0110 3c4.257 0 7.893 2.66 9.336 6.41.147.381.146.804 0 1.186A10.004 10.004 0 0110 17c-4.257 0-7.893-2.66-9.336-6.41zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd" />
                                                </svg>
                                          </span>
                                      </a>
                                      <a href="{{ route('clients.edit',$client->id) }}">
                                          <span class="relative inline-block px-2 py-1 font-semibold text-orange-600 leading-tight">
                                              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
                                                  <path d="M5.433 13.917l1.262-3.155A4 4 0 017.58 9.42l6.92-6.918a2.121 2.121 0 013 3l-6.92 6.918c-.383.383-.84.685-1.343.886l-3.154 1.262a.5.5 0 01-.65-.65z" />
                                                  <path d="M3.5 5.75c0-.69.56-1.25 1.25-1.25H10A.75.75 0 0010 3H4.75A2.75 2.75 0 002 5.75v9.5A2.75 2.75 0 004.75 18h9.5A2.75 2.75 0 0017 15.25V10a.75.75 0 00-1.5 0v5.25c0 .69-.56 1.25-1.25 1.25h-9.5c-.69 0-1.25-.56-1.25-1.25v-9.5z" />
                                                </svg>
                                          </span>
                                      </a>
                                      <form method="POST" action="{{ route('clients.destroy',$client->id) }}">
                                          @csrf
                                          @method('DELETE')
                                          <span class="relative inline-block px-2 py-1 font-semibold text-red-600 leading-tight">
                                              <a href="{{ route('clients.destroy',$client->id) }}" onclick="event.preventDefault(); this.closest('form').submit();">
                                                  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
                                                      <path fill-rule="evenodd" d="M8.75 1A2.75 2.75 0 006 3.75v.443c-.795.077-1.584.176-2.365.298a.75.75 0 10.23 1.482l.149-.022.841 10.518A2.75 2.75 0 007.596 19h4.807a2.75 2.75 0 002.742-2.53l.841-10.52.149.023a.75.75 0 00.23-1.482A41.03 41.03 0 0014 4.193V3.75A2.75 2.75 0 0011.25 1h-2.5zM10 4c.84 0 1.673.025 2.5.075V3.75c0-.69-.56-1.25-1.25-1.25h-2.5c-.69 0-1.25.56-1.25 1.25v.325C8.327 4.025 9.16 4 10 4zM8.58 7.72a.75.75 0 00-1.5.06l.3 7.5a.75.75 0 101.5-.06l-.3-7.5zm4.34.06a.75.75 0 10-1.5-.06l-.3 7.5a.75.75 0 101.5.06l.3-7.5z" clip-rule="evenodd" />
                                                    </svg>
                                              </a>
                                          </span>
                                      </form>
                                  </td> --}}
                              </tr>
                          </tbody>
                          @endforeach
                      </table>
                      <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script>
            // JavaScript
            $(document).ready(function() {
              $("#search-input").on("keyup", function() {
                var value = $(this).val();
                $.ajax({
                  url: "{{ route('search') }}",
                  type: "POST",
                  data: {
                    "_token": "{{ csrf_token() }}",
                    "query": value
                  },
                  success: function(response) {
                    var results = $("#search-results");
                    results.empty(); // clear previous search results
                    if (response.length > 0) {
                      $.each(response, function(key, value) {
                        results.append("<li data-id='" + value.id + "'>" + value.name + "</li>");
                      });
                      $("#search-results li").click(function() {
                        var id = $(this).data("id");
                        var name = $(this).text();
                        $("#search-input").val(name);
                        results.empty(); // clear search results
                      });
                    } else {
                      results.append("<li>No results found.</li>");
                    }
                  },
                  error: function(xhr) {
                    console.log(xhr.responseText);
                  }
                });
              });
            });
            $('#savedb').on('click', function () {
                 var value = $('#search-input').val();
                 var value2 = $('#fingerprint_no').val();
                console.log(value2);
                $.ajax({
                  url: "{{ url('/saving') }}",
                  type: "POST",
                  data: {
                    "_token": "{{ csrf_token() }}",
                    "query1": value,
                    "query2" : value2,
                  },
                  success: function(response) {

                    console.log(response);
                  }
                })

                $.ajax({
                  url: "{{ url('/api/registerfingerprint') }}",
                  type: "POST",
                  data: {
                    "_token": "{{ csrf_token() }}",
                    "query1": value,
                    "query2" : value2,
                  },
                  success: function(response) {

                    console.log(response);
                  }
                })

    });
          </script>
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
                      <div class="mt-4 p-4">
                          {{$patients->links()}}
                      </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>

