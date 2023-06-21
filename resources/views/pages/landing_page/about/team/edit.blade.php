<x-layout.apps>
    <x-slot name="header">
        <button onclick="window.location.href='{{ route('dashboard.about-team.index') }}'"
            class="w-24 my-6 text-white bg-gradient-to-r from-purple-500 via-purple-600 to-purple-700 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-purple-300 dark:focus:ring-purple-800 shadow-lg shadow-purple-500/50 dark:shadow-lg dark:shadow-purple-800/80 font-medium rounded-lg text-sm px-3 py-2.5 text-center mr-2 mb-2">
            <div class="flex items-center">
                <img src="{{ asset('icon/left.png') }}" class="mr-2 bg-white rounded-full" alt="Back" width="25">
                <p class="inline-block">Back</p>
            </div>
        </button>
        <h2 class="my-2 text-2xl font-semibold text-gray-700 dark:text-gray-200">
            Landing Page About Team &raquo; Edit
        </h2>
    </x-slot>

    @section('dashboard')
        <div class="py-3">
            <div
                class="w-full p-6 mx-auto sm:px-6 lg:px-8 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
                <div>
                    @if ($errors->any())
                        <div class="mb-5" role="alert">
                            <div class="bg-red-500 text-white font-bold rounded-t px-4 py-2">
                                There's something wrong!
                            </div>
                            <div class="border border-t-0 border-red-400 rounded-b bg-red-100 px-4 py-3 text-red-700">
                                <p>
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                                </p>
                            </div>
                        </div>
                    @endif
                    <form class="w-full" action="{{ route('dashboard.about-team.update', $landingPageAboutTeam->id) }}"
                        method="post" enctype="multipart/form-data">
                        @csrf
                        @method('put')
                        <div class="flex flex-wrap -mx-3 mb-6">
                            <div class="w-full px-3">
                                <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
                                    for="title_about">
                                    Judul About Team
                                </label>
                                <input value="{{ old('name_people_team', $landingPageAboutTeam->name_people_team) }}"
                                    name="name_people_team"
                                    class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                                    id="name_people_team" type="text" placeholder="Title About Team">
                            </div>
                        </div>
                        <div class="flex flex-wrap -mx-3 mb-6">
                            <div class="w-full px-3">
                                <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
                                    for="title_about">
                                    Job About Team
                                </label>
                                <input value="{{ old('job_people_team', $landingPageAboutTeam->job_people_team) }}"
                                    name="job_people_team"
                                    class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                                    id="job_people_team" type="text" placeholder="Job About Team">
                            </div>
                        </div>
                        <div class="flex flex-wrap -mx-3 mb-6">
                            <div class="w-full px-3">
                                <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
                                    for="description_people_team">
                                    Deskripsi About
                                </label>
                                <textarea name="description_people_team"
                                    class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                                    id="description_people_team" type="text" placeholder="Tulis deskripsi"
                                    value="{{ $landingPageAboutTeam->description_people_team }}">{{ old('description_people_team', $landingPageAboutTeam->description_people_team) }}</textarea>
                            </div>
                        </div>
                        <div class="flex flex-wrap -mx-3 mb-6">
                            <div class="w-full px-3">
                                <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
                                    for="image_people_team">
                                    Gambar About Tean
                                </label>
                                <input multiple accept="image/*" name="image_people_team"
                                    class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400"
                                    id="file_input" type="file" required>

                                <div class="my-3">
                                    <img id="image_element"
                                        src="{{ Storage::url($landingPageAboutTeam->image_people_team) }}"
                                        class="rounded-lg" width="300">
                                </div>
                            </div>
                        </div>
                        <div class="flex flex-wrap -mx-3 mb-6">
                            <div class="w-full px-3 text-right">
                                <button type="submit"
                                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded text-right"
                                    onclick="disableButton(this);">
                                    <div class="flex items-center">
                                        <img src="{{ asset('icon/save.png') }}" alt="save" class="mr-2" width="20"
                                            height="20">
                                        <p id="buttonText">Simpan Update</p>
                                    </div>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        @push('javascript')
            <script>
                function goBack() {
                    window.history.back();
                }
            </script>

            <script>
                function disableButton(button) {
                    button.disabled = true;
                    var buttonText = document.getElementById("buttonText");
                    buttonText.innerText = "Tunggu...";
                    button.form.submit();
                }
            </script>
        @endpush

    @endsection

</x-layout.apps>
