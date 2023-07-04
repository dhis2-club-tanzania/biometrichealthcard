<x-app-layout>
    <div class="bg-gray-100 p-8 rounded-md w-full">
    @if(session('message'))
        <div class='alert alert-success alert-block'>
                <strong>{{ session('message') }}</strong>
        </div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger alert-block">
            <strong>{{ session('error') }}</strong>
        </div>
    @endif
    <div class=" flex items-center justify-between pb-6">
		<div>
			<h2 class="text-gray-600 font-semibold text-l">NHIF MEMBERS</h2>
			<span class="text-s">All NHIF members details</span>
		</div>
		<div class="flex items-center justify-between">
			<div class="flex bg-gray-100 p-2 rounded-md lg:ml-40 ml-10 space-x-8">
				<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" viewBox="0 0 20 20"
					fill="currentColor">
					<path fill-rule="evenodd"
						d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
						clip-rule="evenodd" />
				</svg>
				<input class="bg-white outline-none ml-1 block " type="text" name="" id="" placeholder="search...">
          </div>
          <div class="lg:ml-40 ml-10 space-x-8">
            <a href="{{ route('fingerprint.report')}} ">
                <button class="bg-indigo-600 px-4 py-2 rounded-md text-white font-semibold tracking-wide cursor-pointer">Report</button>
            </a>
          </div>

		</div>
		</div>
		<div>
			<div class="-mx-4 sm:-mx-8 px-4 sm:px-8 py-4 overflow-x-auto">
				<div class="inline-block min-w-full shadow rounded-lg overflow-hidden">
					<table class="min-w-full leading-normal">
						<thead>
							<tr>
                                <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-800 ">
                                    <div class="flex items-center">
                                        <input id="checkbox-table-1" type="checkbox" class="w-4 h-4 bg-gray-800 rounded border-white focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                        <label for="checkbox-table-1" class="sr-only">checkbox</label>
                                    </div>
                                </th>
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
                                <th
									class="px-5 py-3 border-b-2 border-gray-200 bg-gray-800 text-left text-xs font-semibold text-gray-200 uppercase tracking-wider">
									Action
								</th>
							</tr>
						</thead>
                        @foreach ($fingerprints as $fingerprint)
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
								<td class="flex px-5 py-3 border-b border-gray-200 bg-white text-sm">
                                    <form method="POST" action="{{ route('fingerprints.destroy',$fingerprint->fingerprint_no) }}">
                                        @csrf
                                        @method('DELETE')
                                        <a href="{{ route('fingerprints.destroy',$fingerprint->fingerprint_no) }}" onclick="event.preventDefault(); this.closest('form').submit();">
                                            <span class="relative inline-block px-2 py-1 font-semibold text-red-600 leading-tight">
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
                                                <path fill-rule="evenodd" d="M8.75 1A2.75 2.75 0 006 3.75v.443c-.795.077-1.584.176-2.365.298a.75.75 0 10.23 1.482l.149-.022.841 10.518A2.75 2.75 0 007.596 19h4.807a2.75 2.75 0 002.742-2.53l.841-10.52.149.023a.75.75 0 00.23-1.482A41.03 41.03 0 0014 4.193V3.75A2.75 2.75 0 0011.25 1h-2.5zM10 4c.84 0 1.673.025 2.5.075V3.75c0-.69-.56-1.25-1.25-1.25h-2.5c-.69 0-1.25.56-1.25 1.25v.325C8.327 4.025 9.16 4 10 4zM8.58 7.72a.75.75 0 00-1.5.06l.3 7.5a.75.75 0 101.5-.06l-.3-7.5zm4.34.06a.75.75 0 10-1.5-.06l-.3 7.5a.75.75 0 101.5.06l.3-7.5z" clip-rule="evenodd" />
                                              </svg>
                                            </span>
                                        </a>
                                    </form>
								</td>
							</tr>
						</tbody>
                        @endforeach
					</table>

					<div class="mt-4 p-4">
                        {{$fingerprints->links()}}
                    </div>

				</div>
			</div>
		</div>
	</div>
</x-app-layout>
