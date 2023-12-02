FROM nginx:1.19

ARG UID
EXPOSE $UID

# --- Agregamos un usuario dentro de nuestro contenedor con nombre "appuser" ---
RUN adduser -u ${UID} --disabled-password --gecos "" appuser

# --- Copiamos la configuracion de nuestro default.conf a la carpeta dentro de nuestro contenedor ---
COPY default.conf /etc/nginx/conf.d/