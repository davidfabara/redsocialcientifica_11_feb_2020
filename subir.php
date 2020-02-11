<?php  /*<!--El propósito de esta sección de código es mostrarnos la interfaz incluido contenido y archivo adjunto si es una fotografía o documento con su respectivo ícono, atributos del autor de una publicación a subir  --> */ ?>
<script type="text/javascript" src="javascript/subir.js"></script>

<script src="javascript/accesibilidad_subir.js"></script>

<button id="boton_mostrar_subir" class="boton">Subir publicación</button>
<div class="subir" style="display:block;">
    <div class="publi-info-perfil">
        <label for="subir-sms-oculto" onclick="ejecutar_ayuda_subir()"><strong>Ayuda para subir:📢</strong></label>
        <h1 class="speech-post" style="display:none;" id="subir-sms-oculto"></h1>
        <table>
            <tr>
                <td><a href="perfil.php?CodUsua=<?php echo $_SESSION['CodUsua'] ?>"><img src="<?php echo $_SESSION['foto_perfil']; ?>" alt="foto de perfil de: <?php echo $_SESSION['nombre']; ?>" class="publi-img-perfil"></a>
                </td>
                <td><a href="perfil.php?CodUsua=<?php echo $_SESSION['CodUsua'] ?>" class="nombre-usuario">
                        <?php echo $_SESSION['nombre']; ?></a>
                </td>
                <?php 
                /* 	
                    <!--Le he agregado un acceso al perfil del usuario pero solo en la seccion de subir contenidos en el icono de perfil del mismo usuario de la actual sesion, y tambien una descripcion de la foto de perfil para accesibilidad , en la siguiente parte tambien se establece un vinculo al perfil del usuario para el nombre-->
                    
                    <!--Cuando vamos a subir contenido, se cargara en la parte superior la foto de perfil y el nombre del usuario , luego en el FORM action, se receptara input type text y el archivo a subir-->
                */
                ?>
            </tr>
        </table>
    </div>
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" enctype="multipart/form-data" method="post">
        <center>
            <table width="90%" border="1">
                <center>
                    <caption><strong>Introducir datos</strong></caption>
                </center>
                <tbody>
                    <tr>
                        <td>
                            <label for="titulo"><strong>Título:</strong></label></td>
                        <td>
                        <textarea name="titulo" id="titulo" class="contenidos" placeholder="Escribir título " required></textarea><br>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label for="autor"><strong>Autor/es:</strong></label>
                        </td>
                        <td>
                        <textarea type="text" name="autor" id="autor" class="contenidos" placeholder="<?php echo $_SESSION['nombre'] ?>"></textarea><br>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label for="fecha"><strong>Fecha de publicación:</strong></label></td>
                        <td>
                            <textarea name="fecha" id="fecha" class="contenidos" placeholder="<?php echo fechaPost(); ?>"></textarea><br></td>
                    </tr>
                    <tr>
                        <td>
                            <label for="categoria"><strong>Categoría:</strong>
                            </label>
                        </td>
                        <td>
                            <select name="categoria" id="categoria" class="categoria">
                                <option class="opcion" id="opcion1" selected>Ciencias generales</option>
                                <option class="opcion" id="opcion2">Ingeniería</option>
                                <option class="opcion" id="opcion3">Ciencias Sociales</option>
                                <option class="opcion" id="opcion4">Biología, Medicina</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label for="resumen" class="label_contenidos"><strong>Resumen:</strong></label>
                        </td>
                        <td>
                            <div>
                                <?php  /* TODO: Verificar quitar los indices de array bidimensional para el textarea principal de cada <td> */?>
                                <textarea name="subir_cont[resumen][0][0][parrafo]" id="resumen" class="contenidos" rows="4" cols="40" placeholder="Escribir el resumen"></textarea><br>

                                <div class="div_resumen"></div>
                                <div class="div_resumen_select"></div>

                                <hr><br><br><input type="button" value="Crear cita para resumen" class="boton" id="citarRes2" onclick="select_citar('subir_cont','resumen','cita_resumen','div_resumen')">
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label for="introduccion" class="label_contenidos"><strong>Introducción:</strong></label>
                        </td>
                        <td>
                            <div>
                                <textarea name="subir_cont[introduccion][0][0][parrafo]" id="introduccion" class="contenidos" rows="4" cols="40" placeholder="Escribir la introducción"></textarea><br>
                                <div class="div_introduccion"></div>
                                <div class="div_introduccion_select"></div>

                                <hr><br><br><input type="button" value="Crear cita para Introducción" class="boton" id="citarInt2" onclick="select_citar('subir_cont','introduccion','cita_introduccion','div_introduccion')">
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label for="contenido" class="label_contenidos"><strong>Contenido:</strong></label>
                        </td>
                        <td>
                            <div>
                                <textarea name="subir_cont[contenido][0][0][parrafo]" id="contenido" class="contenidos" rows="4" cols="40" placeholder="Escribir el contenido"></textarea><br>
                                <div class="div_contenido"></div>
                                <div class="div_contenido_select"></div>

                                <hr><br><br><input type="button" value="Crear cita para contenido" class="boton" id="citarCont2" onclick="select_citar('subir_cont','contenido','cita_contenido','div_contenido')">
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label for="conclusiones" class="label_contenidos"><strong>Conclusiones:</strong></label>
                        </td>
                        <td>
                        <div>
                                <textarea name="subir_cont[conclusiones][0][0][parrafo]" id="conclusiones" class="contenidos" rows="4" cols="40" placeholder="Escribir las conclusiones"></textarea><br>
                                
                                <div class="div_conclusiones"></div>
                                <div class="div_conclusiones_select"></div>

                                <hr><br><br><input type="button" value="Crear cita para conclusiones" class="boton" id="citarConc2" onclick="select_citar('subir_cont','conclusiones','cita_conclusiones','div_conclusiones')">
                            </div>

                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label for="referencias" class="label_contenidos"><strong>Referencias:</strong></label>
                        </td>
                            
                        <td>
                            <div>
                                <textarea name="subir_cont[referencias][0][0][parrafo]" id="referencias" class="contenidos" rows="4" cols="40" placeholder="Escribir las referencias"></textarea><br>

                                <div class="div_referencias"></div>
                                <div class="div_referencias_select"></div>

                                <hr><br><br><input type="button" value="Crear referencia" class="boton" id="citarRef2" onclick="select_referencia('subir_cont','referencias','cita_referencias','div_referencias')">
                            </div>
                        </td>
                    </tr>
                    <tr>

                        <td>
                            <label for="archivo"><strong>Subir archivo/o nueva versión:</strong></label>
                        </td>
                        <td>
                            <input type="file" name="archivo" id="archivo" class="boton"><br>
                        </td>

                    </tr>
                </tbody>
            </table>
        </center>
        <center>
            <table width="90%" border="1">
                <tbody>
                    <tr>
                        <td><input id="descripcionArchivos" type="button" value="Descripcion Archivos"></td>
                        <td>
                            <div id="addDescripcionArchivos"></div>
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>
                            <div id="addReferencia"></div>
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>
                            <div id="addtabla"></div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </center>
        <center><input id="subir-submit" type="submit" value="Enviar publicación" name="publicar" class="boton"></center>
    </form>
</div>
</div> 