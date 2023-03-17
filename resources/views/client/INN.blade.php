<x-app-layout>
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
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
				<div class="inline-block w-full shadow rounded-lg overflow-hidden">
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
									Fingerprint ID
								</th>
								<th
									class="px-5 py-3 border-b-2 border-gray-200 bg-gray-800 text-left text-xs font-semibold text-gray-200 uppercase tracking-wider">
									Name
								</th>
								<th
									class="px-5 py-3 border-b-2 border-gray-200 bg-gray-800 text-left text-xs font-semibold text-gray-200 uppercase tracking-wider">
									Card No.
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
                        @foreach ($clients as $client)
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
                                        {{$client->id}}
                                    </p>
								</td>
								<td class="px-5 py-3 border-b border-gray-200 bg-white text-sm">
									<p class="text-gray-900 whitespace-no-wrap">{{$client->name}}</p>
								</td>
								<td class="px-5 py-3 border-b border-gray-200 bg-white text-sm">
									<p class="text-gray-900 whitespace-no-wrap">
										{{$client->cardNo}}
									</p>
								</td>
								<td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
									<p class="text-gray-900 whitespace-no-wrap">
										{{$client->status}}
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

                    <div class="mt-4 p-4">
                        {{$clients->links()}}
                    </div>

				</div>
			</div>
		</div>
	</div>
</x-app-layout>
