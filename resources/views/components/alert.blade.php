@if(session('message'))
    {{-- <div class="row mt-3 mb-0 pb-0">
        <div class="col">
            <div class="alert alert-{{ session('message')[0] }}">
                <p>{{ session('message')[1] }}</p>
            </div>
        </div>
    </div> --}}
    <div class="bg-blue-100 border border-blue-400 text-blue-700 px-4 py-3 rounded relative mt-3" role="alert">
        <span class="block sm:inline">{{ session('message')[1] }}</span>
    </div>
@endif
