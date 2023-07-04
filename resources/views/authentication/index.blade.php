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
			<h2 class="text-gray-600 font-semibold text-l">AUTHENTICATION</h2>
			<span class="text-s">All NHIF Members Authentication details</span>
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

		</div>
		</div>
		<div>
			<div class="-mx-4 sm:-mx-8 px-4 sm:px-8 py-4 overflow-x-auto">
				<div class="inline-block min-w-full shadow rounded-lg overflow-hidden">
					<table class="min-w-full leading-normal">
						<thead>
							<tr>
								<th
									class="px-5 py-3 border-b-2 border-gray-200 bg-gray-800 text-left text-xs font-semibold text-gray-200 uppercase tracking-wider">
									S/N
								</th>
                                <th
									class="px-5 py-3 border-b-2 border-gray-200 bg-gray-800 text-left text-xs font-semibold text-gray-200 uppercase tracking-wider">
									Fingerprint User
								</th>
								<th
									class="px-5 py-3 border-b-2 border-gray-200 bg-gray-800 text-left text-xs font-semibold text-gray-200 uppercase tracking-wider">
									Fingerprint No
								</th>
                                <th
									class="px-5 py-3 border-b-2 border-gray-200 bg-gray-800 text-left text-xs font-semibold text-gray-200 uppercase tracking-wider">
									Authentication Status
								</th>
                                <th
									class="px-5 py-3 border-b-2 border-gray-200 bg-gray-800 text-left text-xs font-semibold text-gray-200 uppercase tracking-wider">

								</th>
                                <th
									class="px-5 py-3 border-b-2 border-gray-200 bg-gray-800 text-left text-xs font-semibold text-gray-200 uppercase tracking-wider">

								</th>
							</tr>
						</thead>
                        @foreach ($authentications as $authentication)
						<tbody>
							<tr>
								<td class="px-5 py-3 border-b border-gray-200 bg-white text-sm">
                                    <p class="text-gray-900 whitespace-no-wrap">
                                        {{$authentication->id}}
                                    </p>
								</td>
                                <td class="px-5 py-3 border-b border-gray-200 bg-white text-sm">
									<p class="text-gray-900 whitespace-no-wrap">{{$authentication->authentication_fingerprint_user}}</p>
								</td>
								<td class="px-5 py-3 border-b border-gray-200 bg-white text-sm">
									<p class="text-gray-900 whitespace-no-wrap">{{$authentication->fingerprint_id}}</p>
								</td>
								<td class="px-5 py-3 border-b border-gray-200 bg-white text-sm">
									<p class="text-gray-900 whitespace-no-wrap">
										{{$authentication->authentication_status}}
									</p>
								</td>
                                <td class="px-5 py-3 border-b border-gray-200 bg-white text-sm">
									<a href="{{ route('authentication',['authenticated_id' => $authentication->id ]) }}">
                                        <x-primary-button class="p-2 bg-green-600 w-30">
                                            {{ __('START VISIT') }}
                                        </x-primary-button>
                                    </a>
								</td>
								<td class="flex px-5 py-3 border-b border-gray-200 bg-white text-sm">
                                    <form method="POST" action="{{ route('authentications.destroy',$authentication->id) }}">
                                        @csrf
                                        @method('DELETE')
                                        <a href="{{ route('authentications.destroy',$authentication->id) }}" onclick="event.preventDefault(); this.closest('form').submit();">
                                            <x-primary-button class="bg-red-600" onclick="history.back()">
                                                END VISIT
                                            </x-primary-button>
                                            </span>
                                        </a>
                                    </form>
								</td>
							</tr>
						</tbody>
                        @endforeach
					</table>

					<div class="mt-4 p-4">
                        {{$authentications->links()}}
                    </div>

				</div>
			</div>
		</div>
	</div>
</x-app-layout>
