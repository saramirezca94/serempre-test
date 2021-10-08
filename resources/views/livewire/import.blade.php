<div>
    <form wire:submit.prevent="import" enctype="multipart/form-data">
        @csrf
        <input type="file" wire:model="importFile" class="@error('import_file') is-invalid @enderror">
        <button class="mt-5 p-2 pl-5 pr-5 bg-blue-500 text-gray-100 text-sm rounded-sm focus:border-4 border-blue-300">Import</button>
        @error('import_file')
            <span class="invalid-feedback" role="alert">{{ $message }}</span>
        @enderror
    </form>

    @if($importing && !$importFinished)
        <div wire:poll="updateImportProgress">Importing...please wait.</div>
    @endif

    @if($importFinished)
        Finished importing.
    @endif
</div>
