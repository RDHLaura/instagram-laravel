
<div class="container-avatar-selector">
    <fieldset >
        <!--Creo un selector de avatares por defecto-->
        <legend>Select an avatar:</legend>
        <div class="grid grid-cols-4 gap-0.5 mt-2 mb-2.5">
            <?php
            $dir_path = public_path("sample_avatars"); //se almace la path de la carpeta donde se almacenan los avatares
            $files = array_slice(scandir($dir_path), 2); //enumera los archivos del directorio y los dos primeros del array no son las imagenes por lo que se eliminan       
            //por cada archivo se crea un selector
            foreach ($files as $value){ ?>
                <label>
                    <input type="radio" name="avatar_selector" value="<?php echo "sample_avatars/".$value; ?>" onclick="avatarPreview2()" checked >
                    <img src="<?php echo "sample_avatars/".$value; ?>" class="w-16 h-16 rounded-md object-cover">
                </label>
            <?php
            } ?>
        </div>
    </fieldset> 
</div>

<script>
    function avatarPreview2(){ //muestra
        let avatar = document.getElementById("preview");
        let seleccionado = document.querySelector('input[name="avatar_selector"]:checked').value;

        avatar.src = seleccionado;
    }
</script>