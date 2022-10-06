# PRUEBA TÉCNICA - CASH CONVERTERS

## Instrucciones de ejecución del dockerfile

<br>

**IMPORTANTE**: Hay que modificar las variables del fichero `.env` antes de seguir los siguientes pasos:

1. Abrimos una terminal, accedemos al directorio del proyecto y ejecutamos el siguiente código:

    ```bash
    docker build --pull --rm -f "Dockerfile" -t prueba_cc:latest "."
    ```

2. Una vez ejecutado, lo iniciamos con el siguiente comando:

    ```bash
    docker run -d prueba_cc:latest
    ```
<br>

## Instrucciones para iniciar sesión

A continuación, se exponen dos ejemplos para poder iniciar sesión en la web:

> **Usuario con privilegios**: <br>
> Email: george.bluth@reqres.in <br>
> Contraseña: (Una cualquiera. La API solo comprueba que no esté vacía)

> **Ejemplo de usuario normal**: <br>
> Email: janet.weaver@reqres.in <br>
> Contraseña: (Una cualquiera.)

<br>

## Aclaraciones
<br>

- No se ha desarrollado la funcionalidad de registrar usuario ya que atacamos a una API con ejemplos de usuario y no permite guardar usuarios propios.

-  Se ha *hard-codeado* al usuario con ID 1 en la API de usuarios para que sea un usuario con rol administrador. Se ha hecho de esta forma ya que la respuesta de la API no devuelve un rol o algo para diferenciar tipo de usuarios.

- Todos los textos están preparados para poder ser traducidos. Sin embargo, también se podría haber utilizado una traducción mediante claves (o keys).

- Se ha creado una tabla `user` para guardar una especie de caché de los usuarios que inician sesión en la plataforma.

- Al guardar los pedidos, se guarda el correo electrónico como información del usuario. No se ha relacionado la tabla de pedidos con la de usuarios porque es solo una caché y podría ser limpiada de vez en cuando, perdiendo así, la información del cliente que ha realizado el pedido.

- Hay varias cosas que se podrían mejorar, pero he intentado cumplir los objetivos con respecto al tiempo que disponía. También me hubiera gustado poder añadir algunos test unitarios, pero no he tenido tiempo.