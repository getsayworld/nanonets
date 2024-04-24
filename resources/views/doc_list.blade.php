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
                        <thead class="thead-dark">
                            <tr>
                                <td><b>Document Name</b></td>
                                <td><b>Image</b></td>
                                <td>#</td>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($data as $val)
                            
                                <tr>
                                    <td>{{ $val['filename'] }}</td>
                                    <td><a href="{{  $val['fileurl'] }}" target="blank">show</a></td>
                                    <td><a href="{{ url("doc_details")."/{$val['id']}" }}">View</a></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                </div>

            </div>
        </div>
    </div>
</x-app-layout>
