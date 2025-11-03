# TPE - Películas y Directores
## Integrantes
- Ferraresi Lucía Adela – luciaferraresi30@gmail.com
- Thomassen Carretero Jean Lucas – jeanthomassen.04@gmail.com

## Temática
Películas y Directores

## Descripción
Este proyecto consiste en un sitio web dinámico que permite visualizar películas según su director. 
Cada película pertenece a un solo director. Solo el administrador podrá agregar, modificar o eliminar películas y directores.

## Diagrama Entidad-Relación (DER)
Se incluye el archivo [Diagrama Entidad-Relacion](DER.jpeg) que representa las entidades "Película" y "Director" con una relación de 1 a N:
- Un director puede tener muchas películas.
- Una película pertenece a un solo director.

## SQL
El archivo SQL exportado se encuentra en [database.sql](database.sql) y crea las tablas:
- `Películas`  
- `Directores`
- `Usuarios`
- `resenias` (nueva)
Relaciones:
- Un **director** tiene muchas **películas**
- Una **película** tiene un solo **director**
- Una **película** tiene muchas **reseñas**

## Instalacion / Importar la DB
1. Cloná este repositorio: https://github.com/luciaadelaferraresi/tpe-peliculas-directores
2. Editá config.php (en la raíz) para que coincida con tu entorno local
3. El sistema accede a la base de datos utilizando las constantes definidas en config.php.
4. Si la base de datos no existe, se creará automáticamente y se cargará con datos iniciales definidos en database.sql
5. Iniciá Apache y MySQL desde XAMPP.
6. Abrí el navegador y accedé a la carpeta del proyecto, por ejemplo: http://localhost/nombre-de-tu-carpeta/

# usuario administrador:
Podes iniciar sesión con las siguientes credenciales:
usuario/email: `webadmin`
contraseña: `admin`

## API REST

Esta API permite gestionar **películas** y sus **reseñas**.

---

### Endpoints de Películas

| Método | Endpoint | Descripción |
|--------|---------|-------------|
| GET | `/api/peliculas` | Listar todas las películas |
| GET | `/api/peliculas/:id` | Obtener detalle de una película |
| POST | `/api/peliculas` | Crear una película |
| PUT | `/api/peliculas/:id` | Editar una película |
| DELETE | `/api/peliculas/:id` | Eliminar una película |

#### Respuestas comunes
- **200 OK**: Solicitud correcta  
- **201 Created**: Recurso creado  
- **400 Bad Request**: Datos incompletos o inválidos  
- **404 Not Found**: Película no encontrada  

---

### Endpoints de Reseñas

| Método | Endpoint | Descripción |
|--------|---------|-------------|
| GET | `/api/peliculas/:id/reseñas` | Listar reseñas de una película |
| POST | `/api/peliculas/:id/reseñas` | Crear una reseña |
| DELETE | `/api/peliculas/:id/reseñas` | Eliminar reseña |

#### Respuestas comunes
- **200 OK**
- **201 Created**
- **400 Bad Request**
- **404 Not Found**

---

## ejemplos de uso JSON
A continuación se muestran ejemplos de datos que podrían enviarse a la API.

### Crear pelicula (POST `/api/peliculas`)
{
  "titulo": "Inception",
  "anio": 2010,
  "genero": "Ciencia Ficción",
  "id_director": 3
}
### Editar pelicula (PUT `/api/peliculas/5`)
{
  "titulo": "Inception - Edición Especial",
  "anio": 2010,
  "genero": "Sci-Fi",
  "id_director": 3
}
### Crear reseña (POST `/api/peliculas/5/reseñas`)
{
  "usuario": "pepe",
  "comentario": "Excelente película, muy compleja pero espectacular!",
  "puntaje": 5
}