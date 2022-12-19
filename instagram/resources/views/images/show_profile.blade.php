<x-app-layout>
   <!-- component -->
<div class="relative max-w-5x3 mx-auto my-3">
        <!-- avatar y nombre del usuario -->
        <div class="flex flex-col justify-center items-center my-5">
            <img class="w-24 h-24 bg-cover bg-center bg-no-repeat rounded-full" src="{{ $user->avatar }}" alt="imagen avatar" class="w-8 h-8 rounded-full object-cover mr-2">
            <span class="my-3">{{ $user->username }}</span>
        </div>
        <!-- lista de imagenes del usuario -->
        <div class="grid grid-cols-5 gap-0.5 mt-2">
            @foreach($images as $image)
            <x-instagram-post 
                username="{{ $image->user->username }}" 
                surname="{{ $image->user->surname}}" 
                name="{{ $image->user->name }}"        
                avatar="{{ $image->user->avatar }}"
                image_path="{{ $image->image_path}}"
                description="{{ $image->description }}" 
                likes_count="{{ $image->likes_count }}" 
                comments_count="{{ $image->comments_count }}" 
                user_id="{{ $image->user->id}}"
                image_id="{{ $image->id }}"
                liked_by_user="{{$image->liked_by_user}}" />
            @endforeach
        </div>
        
        @if(Auth::user()->id == $user->id)
        <!-- botón para añadir un post nuevo si el perfil pertenece al usuario autenticado -->
        <div class="sticky bottom-0 left-0 bg-white w-full py-2 px-3 mt-1 text-xs">
            <div class="flex justify-center items-center">               
                <div class="flex flex-col items-center">
                    <a href="{{ route('images.create') }}" class="bg-black text-white px-5 py-2 rounded-md border border-pink-500">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                        </svg>
                    </a>
                </div>
            </div>
        </div>
        <!-- bottom navigation end -->
        @endif
</x-app-layout>


<script type="text/javascript">
/***********************Petición ajax ******************************/
$.ajaxSetup({
    headers: { //se establece el token en el header
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

//se selecciona el botón de like y se configura un eventListener que lanzará la función cuando el botón sea clicado
$(".like_boton").click(function(e){
    //dentro del boton seleccionado hemos definido los valores de la image_id y del user_id, los seleccionamos y almacenamos en variables
    let image_id = $(this).data("image-id"); 
    let user_id = $(this).data("user-id");
	//selecciono el elemento likes_count de la imagen concreta, para ello al elemento le hemos dado un id con el valor de la image_id de forma que sean únicos
    let count_likes = document.getElementById("likes_count_"+image_id);
	//selecciono el icono para poder modificarlo
    let fav = document.getElementById("fav-icon-"+image_id);
   // se hace la petición ajax 
    $.ajax({
        type: 'POST', 
        url: "{{ route('likes.store')}}", 
        data: {
            user_id: user_id,
            image_id: image_id,
        },
        success: function(data) {
			//si la petición ha tenido exito se modifica en el html el valor actualiza del nodo count_likes y el color del icono 
			(fav.classList.contains("text-red-600"))?
				count_likes.textContent = parseInt(count_likes.textContent) -1 :
				count_likes.textContent = parseInt(count_likes.textContent) +1;

            fav.classList.toggle("text-red-600");        
        }
    })
    
})
</script>