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

                    <form action="{{ url('upload') }}" method="post" id="form" enctype="multipart/form-data">
                        @csrf
                        @if (Session::has('success'))
                            <div class="alert alert-success">
                                {{ Session::get('success') }}
                            </div>
                        @endif
                        @if (Session::has('error'))
                            <div class="alert alert-error">
                                {{ Session::get('error') }}
                            </div>
                        @endif
                        <div class="form-group">
                            <label class="custom-file">
                                <input type="file" name="document[]" id="" placeholder="" required multiple
                                    class="form-control" aria-describedby="fileHelpId">
                                <span class="">Select Document</span>
                            </label>
                        </div>

                        <div class="form-group">

                            <button class="btn btn-primary"> Upload</button>
                        </div>

                    </form>

                </div>
                <div class="p-6 text-gray-900">
                    @if (isset($data))
                        @dd($data)
                        @foreach ($data as $value)
                            <table class="table">
                                <tbody>
                                    @foreach ($value['prediction'] as $v)
                                        <tr>
                                            <td scope="row">{{ $v['label'] }}</td>
                                            <td scope="row">{{ $v['ocr_text'] }}</td>
                                        </tr>
                                    @endforeach

                                </tbody>
                            </table>
                        @endforeach
                    @endif

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
