<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Orders') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <header>
                    <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                        {{ __('Order Information') }}
                    </h2>
                </header>

                <form method="post" action="{{ route('orders.update', $order) }}" class="mt-6 space-y-6">
                    @csrf
                    @method('patch')

                    <div>
                        <x-input-label for="client_id" :value="__('Client')" />

                        <select name="client_id" id="client_id"
                            class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                            required>
                            <option disabled hidden selected>Select a client</option>

                            @foreach ($clients as $client)
                                <option value="{{ $client->id }}" @selected($order->client->id === $client->id)>{{ $client->name }}
                                </option>
                            @endforeach
                        </select>

                        <x-input-error class="mt-2" :messages="$errors->get('client_id')" />
                    </div>

                    <div>
                        <x-input-label for="status_id" :value="__('Status')" />

                        <select name="status_id" id="status_id"
                            class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                            required>
                            <option disabled hidden selected>Select a status</option>

                            @foreach ($statuses as $status)
                                <option value="{{ $status->id }}" @selected($order->status->id === $status->id)>{{ $status->name }}
                                </option>
                            @endforeach
                        </select>

                        <x-input-error class="mt-2" :messages="$errors->get('status_id')" />
                    </div>

                    <div>
                        <x-input-label for="comment" :value="__('Comment')" />

                        <x-text-input id="comment" name="comment" type="text" class="mt-1 block w-full"
                            :value="old('comment', $order->comment)" required autofocus autocomplete="comment" />

                        <x-input-error class="mt-2" :messages="$errors->get('comment')" />
                    </div>

                    <div>
                        <x-input-label for="date" :value="__('Date')" />

                        <x-input-date type="date" id="date" name="date" :value="old('date', $order->date?->format('Y-m-d'))" />

                        <x-input-error class="mt-2" :messages="$errors->get('date')" />
                    </div>

                    <div class="flex items-center gap-4">
                        <x-primary-button>{{ __('Save') }}</x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
