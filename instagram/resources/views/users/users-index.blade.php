<x-app-layout>

<!--Buscador de usuarios-->
<div class="max-w-2xl mx-auto m-10">
	<form class="flex items-center" method="GET" action="{{ route('users.index') }}" enctype="multipart/form-data">   
    @csrf	
        <label for="content_search" class="sr-only">Search</label>
        <div class="relative w-full">
            <div class="flex absolute inset-y-0 left-0 items-center pl-3 pointer-events-none">
                <svg class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"></path></svg>
            </div>
            <input type="text" id="content_search" name="content_search" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Search" required>
        </div>
        <button type="submit" class="p-2.5 ml-2 text-sm font-medium text-white bg-blue-700 rounded-lg border border-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg></button>
    </form>
    <script src="https://unpkg.com/flowbite@1.4.0/dist/flowbite.js"></script>
</div>

<!--Listado de usuarios-->
    <div class="justify-center relative top-1/3">
    @foreach($users as $user)
    <div class="relative grid grid-cols-1 gap-4 p-4 mb-8 border rounded-lg bg-white shadow-lg">
        <!--Si pulsas el avatar o el nombre del usuairo te lleva al perfil de este-->
        <form method="GET" action="{{ route('images_user') }}">                        
            <button type="submit">
                <div class="relative flex gap-4">      
                    <input type="hidden" name="user_id" value ="{{ $user->id}}">                     
                    <img src="{{ $user->avatar }}" class="relative rounded-lg -top-8 -mb-4 bg-white border h-20 w-20" alt="" loading="lazy">
                    <div class="flex flex-col w-full">
                        <div class="flex flex-row justify-between">
                            <p class="relative text-xl whitespace-nowrap truncate overflow-hidden">{{ $user->username }}</p>
                        </div>
                        <p class="text-gray-400 text-sm">{{ $user->name }} {{ $user->surname }}</p>
                        <p class="text-gray-400 text-sm">{{  $user->email }}</p>
                    </div> 
                </div>
                <p class="-mt-4 text-gray-500"> {{ $user->create_at }}</p>            
            </button>
        </form>
    </div>
        
    @endforeach
    {{ $users->links() }} <!--para la paginación-->
    </div>
</x-app-layout>