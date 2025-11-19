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
Se incluye el archivo [Diagrama Entidad-Relacion](DER.png) ,  que representa las entidades principales del sistema.

## SQL
El archivo SQL exportado se encuentra en [database.sql](database.sql) y crea las tablas:
- `películas`  
- `directores`
- `usuarios`
- `resenias` (nueva)
Relaciones:
- Un director tiene muchas películas
- Una película tiene un solo director
- Una película tiene muchas reseñas

## Instalacion / Importar la DB
1. Cloná este repositorio: https://github.com/luciaadelaferraresi/api-peliculas-directores
2. Editá config.php (en la raíz) para que coincida con tu entorno local
3. El sistema accede a la base de datos utilizando las constantes definidas en config.php.
4. Si la base de datos no existe, se creará automáticamente y se cargará con datos iniciales definidos en database.sql
5. Iniciá Apache y MySQL desde XAMPP.
6. Abrí el navegador y accedé a la carpeta del proyecto, por ejemplo: http://localhost/nombre-de-tu-carpeta/

# usuario administrador:
Podes iniciar sesión con las siguientes credenciales:
- usuario/email: `webadmin`
- contraseña: `admin`

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

### Endpoints de Reseñas

| Método | Endpoint | Descripción |
|--------|---------|-------------|
| GET | `/api/peliculas/:id/resenias` | Listar reseñas de una película |
| POST | `/api/peliculas/:id/resenias` | Crear una reseña |
| DELETE | `/api/resenias/:id` | Eliminar reseña |
 DELETE | `/api/resenias/:id` | Eliminar reseña |
  DELETE | `/api/resenias/:id` | Eliminar reseña |


### Parámetros de filtrado y orden

- Podés aplicar filtros y ordenamientos combinados en la misma consulta.

| Parámetro | Descripción | Ejemplo |
|------------|-------------|----------|
| `id_director` | Filtra las películas por el ID del director | `/api/peliculas?id_director=2` |
| `anio` | Filtra las películas por año de estreno | `/api/peliculas?anio=2020` |
| `orderBy` | Campo por el cual se ordenan los resultados (`titulo`, `anio`, `id`) | `/api/peliculas?orderBy=titulo` |
| `order` | Dirección del orden (`asc` o `desc`) | `/api/peliculas?orderBy=anio&order=desc` |

- podés filtrar y ordenar las reseñas asociadas a una película específica.

| Parámetro | Descripción | Ejemplo |
|------------|-------------|----------|
| `usuario` | Filtra reseñas por nombre de usuario | `/api/peliculas/5/resenias?usuario=pepe` |
| `puntaje` | Filtra reseñas por puntaje | `/api/peliculas/5/resenias?puntaje=5` |
| `orderBy` | Campo por el cual se ordenan los resultados (`puntaje`, `id`, `usuario`) | `/api/peliculas/5/resenias?orderBy=puntaje` |
| `order` | Dirección del orden (`asc` o `desc`) | `/api/peliculas/5/resenias?orderBy=puntaje&order=desc` |

#### Respuestas comunes
- 200 OK
- 201 Created
- 400 Bad Request
- 401 Unauthorized
- 404 Not Found

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
### Crear reseña (POST `/api/peliculas/5/resenias`)
{
  "usuario": "pepe",
  "comentario": "Excelente película, muy compleja pero espectacular!",
  "puntaje": 5
}
### Autenticación JWT

Para realizar operaciones de modificación (POST, PUT, DELETE), se requiere autenticación mediante token JWT.

#### Obtener Token (Login)
- Método: `POST`
- URL: `http://localhost/api-tpe-web2/api/auth/login`
- Autenticación: Basic Auth  
- Usuario: `webadmin`  
- Contraseña: `admin`

- incluir el token en el encabezado de peticiones:
  Authorization: Bearer <token>

- Solo los usuarios con rol "admin" pueden crear, editar o eliminar películas y reseñas.