<x-app-layout>
	<section class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-0.5 mt-2"> <!--Contenedor tipo grid -->
    
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
    
	</section>


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