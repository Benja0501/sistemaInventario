# Sistema de Gestión de Inventario para FEMAZA S.A.

Este proyecto es un sistema de gestión de inventario y control de stock desarrollado a medida para la empresa **FEMAZA S.A.**, ubicada en Guadalupe, Perú. El objetivo principal de la aplicación es optimizar y automatizar los procesos de almacén para reducir pérdidas, mejorar la eficiencia y proporcionar datos fiables para la toma de decisiones.

---

## Características Principales

El sistema está diseñado con una arquitectura robusta y segura, e incluye los siguientes módulos y funcionalidades:

* **Dashboard Interactivo:** Panel principal con indicadores clave (KPIs) como valor del inventario, productos con bajo stock, órdenes pendientes y últimos movimientos.
* **Gestión de Usuarios y Roles:** Sistema de autenticación con tres roles definidos (`Supervisor`, `Compras`, `Almacén`) y permisos específicos para cada uno.
* **Catálogos Completos:** Módulos CRUD (Crear, Leer, Actualizar, Desactivar) para gestionar:
    * Productos
    * Categorías
    * Proveedores
* **Ciclo de Compras Detallado:**
    * Creación de Órdenes de Compra con múltiples productos.
    * Flujo de aprobación por parte de un Supervisor.
    * Registro de recepción de mercadería (total o parcial).
* **Control de Inventario Preciso:**
    * Registro de todas las entradas de stock, ya sea por compra o manuales (devoluciones, ajustes).
    * Registro de todas las salidas de stock (mermas, ajustes por faltante).
    * Trazabilidad de productos por **lote** y **fecha de vencimiento**.
* **Sistema de Alertas y Notificaciones:**
    * Notificaciones automáticas para productos con **stock bajo**.
    * Notificaciones automáticas diarias para productos **próximos a vencer**.
    * Sistema para que los supervisores envíen **alertas manuales** a otros usuarios.
* **Auditoría y Control:**
    * Módulo para generar **Informes de Discrepancia** a partir de conteos físicos.
    * Funcionalidad para que el supervisor **ajuste el stock** del sistema basándose en un informe de discrepancia.

## Tecnologías Utilizadas

* **Backend:** Laravel 12 / PHP 8.2
* **Base de Datos:** Microsoft SQL Server
* **Frontend:** Blade, HTML5, CSS3, JavaScript
* **Librerías Principales:**
    * DataTables.js para tablas dinámicas.
    * Bootstrap (o un tema similar) para el diseño del panel.

## Instalación y Puesta en Marcha

Para ejecutar este proyecto en un entorno de desarrollo local, sigue estos pasos:

1.  **Clonar el repositorio:**
    ```bash
    git clone [URL_DEL_REPOSITORIO]
    cd [NOMBRE_DEL_PROYECTO]
    ```

2.  **Instalar dependencias:**
    ```bash
    composer install
    npm install
    ```

3.  **Configurar el entorno:**
    * Crea una copia del archivo `.env.example` y renómbralo a `.env`.
    * Configura las variables de tu base de datos (`DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD`, etc.).

4.  **Generar la clave de la aplicación:**
    ```bash
    php artisan key:generate
    ```

5.  **Ejecutar las migraciones y los seeders:**
    * Este comando creará todas las tablas y registrará el usuario Supervisor inicial.
    ```bash
    php artisan migrate:fresh --seed
    ```

6.  **Compilar los assets:**
    ```bash
    npm run dev
    ```

7.  **Iniciar el servidor:**
    ```bash
    php artisan serve
    ```

Ahora puedes acceder a la aplicación desde tu navegador en la dirección que te indique la terminal (usualmente `http://127.0.0.1:8000`).

## Licencia

El framework Laravel es un software de código abierto licenciado bajo la [Licencia MIT](https://opensource.org/licenses/MIT).