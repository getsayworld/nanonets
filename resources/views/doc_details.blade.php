<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <td><b>Document Name</b></td>
                                <td >
                                    {{ $data['filename'] }}
                                </td>
                            </tr>
                        </thead>
                        <tbody>
                            @if (isset($doc_data))
                            {{-- @dd($doc_data) --}}
                                @foreach ($doc_data['prediction'] as $cl)
                                    <tr>
                                        <td>{{ $cl['label'] }}</td>
                                        <td>{{ $cl['ocr_text'] }}</td>
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>

                </div>

            </div>
        </div>
    </div>
</x-app-layout>
