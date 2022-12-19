@props([
  'username' => "text",
  'surname' => "text",
  'name' => "text",
  'avatar' => "text",
  'image_path' => "text", 
  'description' => "text",
  'likes_count' => 0,
  'comments_count' => 0,
  'user_id' => 0,
  'image_id' => 0,
  'liked_by_user' => null,
  ])
<!-- component -->
<div class="bg-gray-100 p-4">
    <div class="bg-white border rounded-sm max-w-md">
        <div class="flex justify-between">
            <!--Encabezado de la imagen con el nombre del usuario que la postea y que lleva al perfil de este-->
            <form method="GET" action="{{ route('images_user') }}">                        
                <input type="hidden" name="user_id" value ="{{ $user_id}}">                    
                <button type="submit">
                    <div class="flex items-center px-4 py-3">
                        <img class="h-8 w-8 rounded-full" src="{{ $avatar }}"/>
                        <div class="ml-3 ">
                            <span class="text-sm font-semibold antialiased block leading-tight">{{ $username}}</span>
                            <span class="text-gray-600 text-xs block">{{ $surname }}, {{ $name }}</span>
                        </div>
                    </div>
                </button>
            </form>
        @if(Auth::user()->id == $user_id)		
        <!--Botón de eliminar con el mensaje de confirmación-->
            <div class="flex mt-0 ">	
                <button type="submit" class="ml-2 mr-4 underline  mt-4" x-data=""
                    x-on:click.prevent="$dispatch('open-modal', 'confirm-image-deletion')">
                    <svg xmlns="http://www.w3.org/2000/svg" width="44" height="44" fill="#adadad" viewBox="0 0 16 16" class="pb-3">
                        <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z" />
                    </svg>
                </button>
                <x-modal name="confirm-image-deletion" :show="$errors->imageDeletion->isNotEmpty()" focusable>		
                    <form method="POST" action="{{ route('images.destroy', $image_id) }}" enctype="multipart/form-data" class="p-6">
                        @method('DELETE')
                        @csrf			
                        <h2 class="text-lg font-medium text-gray-900">¿Desea eliminar la imagen?</h2>			
                        <x-danger-button class="ml-3">
                            {{ __('Confirmar') }}
                        </x-danger-button>
                        <x-secondary-button x-on:click="$dispatch('close')">
                            {{ __('Cancel') }}
                        </x-secondary-button>						
                    </form>
                </x-modal>
            </div>	
        @endif
    </div>
    <!-- Imagen y contenido -->
    <form method="GET" action="{{ route('image_detail') }}"> <!--Convierte la imagen en un botón que lleva a su vista detallada -->
        @csrf
        <input type="hidden" name="image_id" value ="{{ $image_id }}">     
        <input type="hidden" name="user_id" value ="{{ $user_id }}"> 
        <button type="submit">
            <img src="{{ $image_path}}" />     
        </button>
    </form>
    <div class="flex items-center justify-between mx-4 mt-3 mb-2">
        <div class="flex gap-5">
            <!--botón de likes -->
            <button 
                type="button" 
                class="like_boton"
                data-image-id= "{{ $image_id }}"
                data-user-id="{{ $user_id }}"> 
                <a id="fav-icon-{{ $image_id }}" class="fa-solid fa-heart {{ $liked_by_user == null ? '' : 'text-red-600';}}" ></a>                    
            </button>
            <div id="likes_count_{{$image_id}}" class="font-semibold text-sm mx-4 mt-2 mb-4">{{ $likes_count }}</div>
            <!--botón de comentarios -->
            <form method="GET" action="{{ route('image_detail') }}">
                @csrf
                <button type="submit" > <!--boton comentarios-->
                    <input type="hidden" name="image_id" value ="{{ $image_id }}">
                    <svg id="fav-icon" fill="#262626" height="24" viewBox="0 0 48 48" width="24"><path clip-rule="evenodd" d="M47.5 46.1l-2.8-11c1.8-3.3 2.8-7.1 2.8-11.1C47.5 11 37 .5 24 .5S.5 11 .5 24 11 47.5 24 47.5c4 0 7.8-1 11.1-2.8l11 2.8c.8.2 1.6-.6 1.4-1.4zm-3-22.1c0 4-1 7-2.6 10-.2.4-.3.9-.2 1.4l2.1 8.4-8.3-2.1c-.5-.1-1-.1-1.4.2-1.8 1-5.2 2.6-10 2.6-11.4 0-20.6-9.2-20.6-20.5S12.7 3.5 24 3.5 44.5 12.7 44.5 24z" fill-rule="evenodd"></path></svg>
                </button>
            </form>
            <div class="font-semibold text-sm mx-4 mt-2 mb-4">{{ $comments_count }}</div>
        </div>
    </div>
    <!--Descripción-->
    <div class="font-light text-sm mx-4 mt-2 mb-4"><p>{{ $description }}</p></div>
    </div>
</div>
