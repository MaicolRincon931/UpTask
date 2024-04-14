<div class="contenedor login">
    <?php
    include_once __DIR__ . '/../templates/nombre-sitio.php';
    ?>

    <div class="contenedor-sm">
        <p class="descripcion-pagina">Inciar Sesión</p>

        <?php
    include_once __DIR__ . '/../templates/alertas.php';
    ?>

        <form class="formulario" method="POST" action="/" novalidate>

           
            <div class="campo">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" placeholder="Tu Email">
            </div>

            <div class="campo">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" placeholder="Tu password">
            </div>

            <input type="submit" class="boton" value="Iniciar Sesión">

        </form>

        <div class="acciones">
            <a href="/crear">¿Aún no tienes una cuenta? Crea una</a>
            <a href="/olvide">¿Olvidaste tu password? Recuperalo</a>
        </div>
    </div> <!--Contenedor sm -->

</div>