(function(){
    //Boton para mostrar el modal de Agregar Tarea

    const nuevaTareaBtn = document.querySelector('#agregar-tarea');
    nuevaTareaBtn.addEventListener('click',mostrarFormulario);

    function mostrarFormulario(){
        const modal = document.createElement('DIV');
        modal.classList.add('modal');
        modal.innerHTML = `
            <form class="formulario nueva-tarea">
                <legend>Añade una nueva Tarea</legend>
                <div class="campo">
                    <label>Tarea</label>
                    <input 
                        type="text"
                        name="tarea"
                        placeholder="Añadir Tarea al Proyecto Actual"
                        id="tarea"
                    >
                </div>
                <div class="opciones">
                    <input type="submit" class="submit-nueva-tarea" value="Añadir Tarea" />
                    <button type="button" class="cerrar-modal">Cancelar</button>
                </div>
            </form>
        `;
        setTimeout(()=>{
            const formulario = document.querySelector('.formulario')
            formulario.classList.add('animar');
        }, 0);

        modal.addEventListener('click',function(e){

        });

        document.querySelector('body').appendChild(modal);
    }

})();