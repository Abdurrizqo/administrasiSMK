<div class="w-full bg-gray-100 border-t flex items-center justify-center px-4 pb-10 pt-5">

    <form wire:submit.prevent="saveMessage" class="w-[80%]">
        <div class="flex justify-start items-center mb-5 gap-5">
            @if (!$dataFile)
                <label for="fileUpload"
                    class="btn-click cursor-pointer border shadow-lg bg-white rounded-full flex justify-center items-center p-2">
                    <span class="material-icons text-gray-800">
                        attach_file
                    </span>
                </label>
            @endif

            @if ($dataFile)
                <label wire:click="removeImage"
                    class="btn-click cursor-pointer border shadow-lg bg-white rounded-full flex justify-center items-center p-2">
                    <span class="material-icons text-red-500">
                        delete
                    </span>
                </label>
            @endif

            <input wire:model="dataFile" type="file" id="fileUpload" class="hidden">

            <div wire:loading wire:target="dataFile" class="text-gray-600 poppins-light">Uploading...
            </div>

            @error('dataFile')
                <span class="text-red-400 poppins-light text-xs">{{ $message }}</span>
            @enderror
        </div>

        <div class="flex gap-3 items-center justify-start">
            <textarea wire:model="message" class="border shadow-lg rounded p-2 text-sm min-h-28 outline-none w-full"></textarea>
            <button type="submit"
                class="btn-click bg-white shadow-lg border rounded-full flex justify-center items-center p-2">
                <span class="material-icons text-gray-800">
                    send
                </span>
            </button>
        </div>
    </form>
</div>
