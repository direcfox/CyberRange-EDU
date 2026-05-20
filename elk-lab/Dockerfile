FROM ubuntu:22.04

# Evitar prompts durante la instalación
ENV DEBIAN_FRONTEND=noninteractive

# Instalar dependencias
RUN apt update && \
    apt install -y snort net-tools iproute2 vim

# Crear directorio de logs
RUN mkdir -p /var/log/snort

# Copiar un archivo de configuración base (puedes personalizar después)
RUN cp /etc/snort/snort.conf.example /etc/snort/snort.conf || true

RUN apt update && \
    apt install -y snort oinkmaster && \
    mkdir -p /usr/local/lib/snort_dynamicpreprocessor/



# Establecer modo de ejecución por defecto

