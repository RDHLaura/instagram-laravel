@props([
    'username' => "text",
    'avatar' => "text", 
    'content' => "text",
    'create_at' => "text",
])

<div class="flex justify-center relative top-1/3">

    <!-- This is an example component -->
    <div class="relative grid grid-cols-1 gap-4 p-4 mb-8 border rounded-lg bg-white shadow-lg">
        <div class="relative flex gap-4">
            <img src="{{ $avatar }}" class="relative rounded-lg -top-8 -mb-4 bg-white border h-20 w-20" alt="" loading="lazy">
            <div class="flex flex-col w-full">
                <div class="flex flex-row justify-between">
                    <p class="relative text-xl whitespace-nowrap truncate overflow-hidden">{{ $username }}</p>
                </div>
                <p class="text-gray-400 text-sm">{{ $content }}</p>
            </div> 
        </div>
        <p class="-mt-4 text-gray-500"> {{ $create_at }}</p>
    </div>
</div>