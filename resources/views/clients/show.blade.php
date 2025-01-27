<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Clients') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <header>
                    <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">
                        {{ __('Client Information') }}
                    </h2>
                </header>

                <div class="text-gray-700 dark:text-gray-200">
                    <p>Name: {{ $client->name }}</p>
                    <p>Synced At: {{ $client->synced_at }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
        <div class="p-6 bg-white dark:bg-gray-800 shadow sm:rounded-lg">

            <select name="status_id" id="status_id"
                class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm mb-6"
                x-data
                @change="window.location.href = '{{ route('clients.show', $client) }}' + '?status_id=' + $event.target.value"
                required>
                <option value="" selected>All Statuses</option>

                @foreach ($statuses as $status)
                    <option value="{{ $status->id }}" @selected(request()->get('status_id') == $status->id)>
                        {{ $status->name }}
                    </option>
                @endforeach
            </select>

            <div class="flex">
                <a href="{{ route('clients.orders.create', $client) }}"
                    class="px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150 mb-6">
                    Create
                </a>
            </div>

            @if (session()->has('success'))
                <span x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
                    class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 tracking-widest mb-6">
                    {{ session()->get('success') }}
                </span>
            @endif

            <div
                class="relative flex flex-col w-full h-full overflow-scroll text-gray-700 bg-white shadow-md rounded-lg bg-clip-border">
                <table class="w-full text-left table-auto min-w-max">
                    <thead>
                        <tr>
                            <th class="p-4">
                                <p class="block text-sm font-normal leading-none text-slate-500">
                                    Comment
                                </p>
                            </th>
                            <th class="p-4">
                                <p class="block text-sm font-normal leading-none text-slate-500">
                                    Status
                                </p>
                            </th>
                            <th class="p-4">
                                <p class="block text-sm font-normal leading-none text-slate-500">
                                    Date
                                </p>
                            </th>
                            <th class="p-4">
                                <p class="block text-sm font-normal leading-none text-slate-500">
                                    Synced At
                                </p>
                            </th>
                            <th class="p-4">
                                <p class="block text-sm font-normal leading-none text-slate-500">
                                    Files
                                </p>
                            </th>
                            <th class="p-4">
                                <p class="block text-sm font-normal leading-none text-slate-500">
                                    Actions
                                </p>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($orders as $order)
                            <tr class="border-t border-slate-200">
                                <td class="p-4">
                                    <p class="block text-sm text-slate-800">
                                        {{ $order->comment }}
                                    </p>
                                </td>
                                <td class="p-4">
                                    <span class="inline-flex items-center p-2 text-xs font-medium bg-gray-200">
                                        {{ $order->status->name }}
                                    </span>
                                </td>
                                <td class="p-4">
                                    <p class="block text-sm text-slate-800">
                                        {{ $order->date?->diffForHumans() }}
                                    </p>
                                </td>
                                <td class="p-4">
                                    <p class="block text-sm text-slate-800">
                                        {{ $order->synced_at?->format('d/m/Y H:i') }}
                                    </p>
                                </td>
                                <td class="p-4">
                                    @foreach ($order->files ?? [] as $file)
                                        <a href="{{ Storage::url($file) }}" target="_blank"
                                            class="block text-sm text-blue-500 hover:text-blue-700">
                                            {{ str(basename($file))->limit(10) }}
                                        </a>
                                    @endforeach
                                </td>
                                <td class="p-4">
                                    <a href="{{ route('orders.edit', $order) }}"
                                        class="block inline-flex items-center px-4 py-2 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-500 rounded-md font-semibold text-xs text-gray-700 dark:text-gray-300 uppercase tracking-widest shadow-sm hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 disabled:opacity-25 transition ease-in-out duration-150">
                                        Edit
                                    </a>
                                    <form method="post" action="{{ route('orders.destroy', $order) }}"
                                        class="inline-block mx-5">
                                        @csrf
                                        @method('DELETE')
                                        <x-danger-button>
                                            {{ __('Delete') }}
                                        </x-danger-button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="mt-6">
                {{ $orders->withQueryString()->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
