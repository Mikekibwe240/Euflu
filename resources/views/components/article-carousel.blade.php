<div x-data="{ active: 0 }" class="relative w-full max-w-lg mx-auto">
    <div class="overflow-hidden rounded shadow">
        @foreach($images as $i => $img)
            <img 
                x-show="active === {{ $i }}" 
                src="{{ asset('storage/' . $img->path) }}" 
                alt="Image article"
                class="w-full h-64 object-cover rounded mb-4 border border-gray-200 dark:border-gray-700 bg-white block mx-auto align-middle"
                style="object-fit:cover;object-position:center;"
                onerror="this.style.display='none'"
            />
        @endforeach
    </div>
    <div class="flex justify-center mt-2 gap-2">
        @foreach($images as $i => $img)
            <button type="button" @click="active = {{ $i }}" :class="active === {{ $i }} ? 'bg-blue-600' : 'bg-gray-400'" class="w-3 h-3 rounded-full"></button>
        @endforeach
    </div>
</div>
