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

                <form method="post" action="{{ route('orders.store') }}" class="mt-6 space-y-6"
                    enctype="multipart/form-data">
                    @csrf

                    <div>
                        <x-input-label for="client" :value="__('Client')" />

                        <select name="client_id" id="client"
                            class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                            required>
                            <option disabled hidden selected>Select a client</option>

                            @foreach ($clients as $client)
                                <option value="{{ $client->id }}">{{ $client->name }}</option>
                            @endforeach
                        </select>

                        <x-input-error class="mt-2" :messages="$errors->get('client_id')" />
                    </div>

                    <div>
                        <x-input-label for="comment" :value="__('Comment')" />

                        <x-text-input id="comment" name="comment" type="text" class="mt-1 block w-full"
                            :value="old('comment')" required autofocus autocomplete="comment" />

                        <x-input-error class="mt-2" :messages="$errors->get('comment')" />
                    </div>

                    <div>
                        <x-input-label for="date" :value="__('Date')" />

                        <x-input-date type="date" id="date" name="date" :value="old('date')" />

                        <x-input-error class="mt-2" :messages="$errors->get('date')" />
                    </div>

                    <div>
                        <x-input-label for="files" :value="__('Files')" />

                        <input type="file" name="files[]" id="files" multiple
                            class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm p-2 mb-6"
                            accept=".jpg,.jpeg,.png,.pdf,.doc,.docx" />

                        @foreach ($errors->get('files.*') as $error)
                            <x-input-error class="mt-2" :messages="$error" />
                        @endforeach
                    </div>

                    <div class="flex items-center gap-4">
                        <x-primary-button>{{ __('Save') }}</x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
