<x-app-layout>
	<section class="flex justify-center mt-20 "> <!--Contenedor tipo grid -->
	<!--Contenedor tipo grid -->
	<div>
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
		<!--Si el creador de la imagen es el usuario autenticado muestra los botones de editar descripción-->
		@if(Auth::user()->id == $image->user->id)
		<a onClick="show_form('form-update-image')" class="ml-2 mr-4 underline  mt-4">{{ __('Editar descripción') }}</a>
		<form id="form-update-image" class="mt-0 hidden w-5/6" method="POST" action="{{ route('images.update', $image->id) }}" enctype="multipart/form-data">
			@csrf	
			@method("PUT")	
			<div class="mt-4 ">
				<textarea name="description" id="description"  rows="3" value="{{ $image->description }}" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 "></textarea>
			</div>
			<div class="flex items-center justify-end mt-4">
				<x-primary-button class="ml-4 mr-9">
					{{ __('Guardar') }}
				</x-primary-button>
			</div>						
		</form>
		@endif
	</div>
	<div class="flex-column justify-center m-9">
		@foreach($comments as $comment)
			<!--<x-comment
				username= "{{ $comment->user->username }}"
				avatar= "{{ $comment->user->avatar }}"
				content="{{ $comment->content }}"
				create_at="{{ $comment->created_at }}"/> -->

			<!--Lista los comentarios de esa foto-->
		<div class="relative grid grid-cols-1 gap-4 p-4 mb-8 border rounded-lg bg-white shadow-lg">
			<div class="relative flex gap-4">					
				<img src="{{ $comment->user->avatar }}" class="relative rounded-lg -top-8 -mb-4 bg-white border h-20 w-20" alt="" loading="lazy">
				<div class="flex flex-col w-full">
					<div class="flex flex-row justify-between">
						<p class="relative text-xl whitespace-nowrap truncate overflow-hidden">{{ $comment->user->username }}</p>
					</div>
					<p class="text-gray-400 text-sm">{{ $comment->content }}</p>
				</div>
				<p class="-mt-4 text-gray-500"> {{ $comment->created_at }}</p>				
			</div>
			<!--Bloque que se activa si el comentario pertenece al usuario autenticado y permite eliminar o modificarlo-->
			@if(Auth::user()->id == $comment->user->id or Auth::user()->id == $image->user->id)	
				<div  class="flex mt-0">
					<!--Opción de eliminación con ventana de confirmación-->
					<button type="submit" class="ml-2 mr-4 underline  mt-4" x-data=""
						x-on:click.prevent="$dispatch('open-modal', 'confirm-comment-deletion-{{ $comment->id }}')">
						{{ __('Eliminar') }}
					</button>	
					<x-modal name="confirm-comment-deletion-{{ $comment->id }}" :show="$errors->commentDeletion->isNotEmpty()" focusable>		
						<form method="POST" action="{{ route('comment.destroy', $comment->id) }}" enctype="multipart/form-data" class="p-6">
							@method('DELETE')
							@csrf			
							<h2 class="text-lg font-medium text-gray-900">¿Desea eliminar el comentario?</h2>		
							<x-danger-button class="ml-3">
								{{ __('Confirmar') }}
							</x-danger-button>
							<x-secondary-button x-on:click="$dispatch('close')">
								{{ __('Cancel') }}
							</x-secondary-button>					
						</form>
					</x-modal>
					<!-- activa un desplegable que permite editar el comentario -->
					<a onClick="show_form('form-update-comment{{ $comment->id }}')" class="ml-2 mr-4 underline  mt-4"> {{ __('Editar') }} </a>
					<form id="form-update-comment{{ $comment->id }}" class="mt-0 hidden w-5/6" method="POST" action="{{ route('comment.update', $comment->id) }}" enctype="multipart/form-data">
						@csrf	
						@method("PUT")	
						<div class="mt-4 ">
							<textarea name="comment_content" id="comment_content"  rows="3" value="{{ $comment->content }}" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 "></textarea>
						</div>
						<div class="flex items-center justify-end mt-4">
							<x-primary-button class="ml-4 mr-9">
								{{ __('Guardar') }}
							</x-primary-button>
						</div>						
					</form>
				</div>	
			@endif
		</div>
		@endforeach
		
		<form method="POST" action="{{ route('comment.store') }}" enctype="multipart/form-data">
			@csrf
			<!-- Name -->
			<div class="mt-4 ">
				<textarea name="comment" id="comment"  rows="4" placeholder="Your message..." class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"></textarea>
			</div>
			<input type="hidden" name="image_id" value ="{{ $image->id}}">
			<input type="hidden" name="image_id" value ="{{ $image->id}}">
			<div class="flex items-center justify-end mt-4">
				<x-primary-button class="ml-4 mr-9">{{ __('Comentar') }}</x-primary-button>
			</div>
		</form>
		</div>
	</section>
</x-app-layout>

<!--Scripts-->
<script type="text/javascript">
//muestra u oculta el elemento con el id que se le pase por parámetro
function show_form(id){
	let form = document.getElementById(id);
	form.classList.toggle("hidden");
}


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