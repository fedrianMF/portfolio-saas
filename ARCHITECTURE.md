# 🏗 Arquitectura del Proyecto: SaaS Portfolio (`fedrian.dev`)

Este documento describe la infraestructura, el stack tecnológico y los flujos de trabajo del proyecto **SaaS Portfolio**, propiedad de **Felix Adrian**.

## 🎯 Propósito del Proyecto
Este no es solo un portafolio estático; es un **Showcase de Ingeniería Full-Stack y DevOps**. El sistema está diseñado para demostrar habilidades avanzadas en:
* **Backend:** Laravel 12 manejando telemetría de sistema y tareas programadas efímeras.
* **DevOps:** Orquestación con Docker, monitoreo de recursos y CI/CD automatizado.
* **Linux/SysAdmin:** Gestión de procesos, permisos y seguridad de nivel servidor.

**Nota de Seguridad:** El sistema permite el registro de reclutadores con cuentas de ciclo de vida limitado. Un proceso automatizado mediante Redis Queues elimina estas identidades periódicamente para garantizar la limpieza y seguridad del entorno.

---

## 🚀 Stack Tecnológico

* **Framework:** Laravel 12 (PHP 8.2+).
* **Entorno de Ejecución:** Docker & Docker Compose (Arquitectura de microservicios).
* **Base de Datos:** PostgreSQL 15.
* **Caché y Mensajería:** Redis (Alpine).
* **Servidor Web:** Nginx.
* **Gestión de SSL:** Nginx Proxy Manager (Contenedor Externo).
* **Automatización:** n8n (Containerizado).

---

## 🛠 Infraestructura y Orquestación

El proyecto opera sobre un VPS con una arquitectura basada en contenedores. Los servicios principales están orquestados mediante `docker-compose.prod.yml`.

### Contenedores Core:
1.  **`saas_app`**: Servidor de aplicaciones Laravel.
    * Incluye **Supervisor** para la gestión de procesos en segundo plano.
    * Workers activos: `laravel-worker_00` y `laravel-worker_01`.
2.  **`saas_db`**: Instancia de PostgreSQL con persistencia de datos mediante volúmenes de Docker.
3.  **`saas_redis`**: Broker para colas (Queues) y motor de caché.

---

## 🔄 Flujo de CI/CD (Despliegue Continuo)

Contamos con un sistema de despliegue automatizado y manual optimizado para la estabilidad:

### 1. Producción (`branch: prod`)
* **Trigger**: Automático al hacer `push` a la rama `prod`.
* **Proceso**: GitHub Actions vía SSH ejecuta el despliegue sin intervención manual.

### 2. Desarrollo/Staging (`branch: dev`)
* **Trigger**: Manual en el VPS tras hacer `push` a la rama `dev`.
* **Proceso**: Se utiliza el script inteligente `./deploy.sh` que detecta la rama activa, sincroniza el código y reinicia servicios.



---

## 📂 Scripts de Gestión y Diagnóstico

Para facilitar el mantenimiento, se han implementado los siguientes scripts en el VPS:

* **`~/health-check.sh`**: Diagnóstico integral del sistema (Verifica estado de contenedores, conectividad DB/Redis, integridad de Workers y logs).
* **`~/setup-env.sh`**: Gestión segura de variables de entorno `.env`.
* **`./deploy.sh`**: Automatiza la corrección de permisos (`chown`), sincronización de código (`git reset --hard`) y despliegue de Docker.

---

## 🔐 Gestión de Permisos y Seguridad

El sistema maneja automáticamente los permisos de las carpetas críticas de Laravel (`storage` y `bootstrap/cache`). El script de despliegue asegura que el usuario `www-data` (interno al contenedor) y el usuario del sistema (`fedrian`) puedan operar sin conflictos de propiedad de archivos.

---

## 📝 Notas para el Desarrollo (Antigravity)

1.  **Integridad de Datos**: Toda alteración en la DB debe realizarse mediante migraciones de Laravel ejecutadas con el flag `--force`.
2.  **Persistencia**: Los datos residen en volúmenes de Docker; no almacenar archivos críticos fuera de las rutas mapeadas.
3.  **Monitoreo**: Antes de reportar un error de infraestructura, ejecutar el script `~/health-check.sh`.