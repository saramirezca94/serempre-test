<div>
    <button class="mt-5 p-2 pl-5 pr-5 bg-blue-500 text-gray-100 text-sm rounded-sm focus:border-4 border-blue-300" wire:click="export">Export</button>

    @if($exporting && !$exportFinished)
        <div class="d-inline" wire:poll="updateExportProgress">Exporting...please wait.</div>
    @endif

    @if($exportFinished)
        Done. Download file <a wire:click="downloadExport">here</a>
    @endif
</div>
