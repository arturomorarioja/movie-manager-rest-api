# KEA.dk - REST API Example
# Movie Manager

## Purpose
This is a sample REST API for students of the elective subject Web Application Development in the Professional Bachelor Degree in Software Development at KEA (Københavns Erhvervsakademi / Copenhagen School of Design and Technology). The API is a movie manager where the user can get, browse, search, add, modify, and delete names of movies.

## API Documentation

#### Main usage:

http://_<server_name>_/kea-movie-manager-rest-api/_<endpoint>_

#### Endpoints:

| Method | Usage        | Description                         |
| ------ |:------------ |:----------------------------------- |
| GET    |/    | Returns the API description for GET methods     |
| GET    |/movies    | Returns all movie IDs and names     |
| GET    |/movies?s=_<search_text>_ | Returns the IDs and names of those movies whose name contains _<search_text>_ |
| GET    |/movies/_<movie_id>_ | Returns the ID and name of the movie with ID _<movie_id>_ |
| POST   |/movies | Adds a movie |
| PUT    |/movies/_<movie_id>_ | Updates the name of the movie with ID _<movie_id>_ |
| DELETE    |/movies/_<movie_id>_ | Deletes the movie with ID _<movie_id>_ |

#### Examples:
For the examples below, the API is assumed to run at `http://localhost/kea-movie-manager-rest-api`.

GET http://localhost/kea-movie-manager-rest-api/
GET http://localhost/kea-movie-manager-rest-api/movies
GET http://localhost/kea-movie-manager-rest-api/movies?name=Star
GET http://localhost/kea-movie-manager-rest-api/movies/4
POST http://localhost/kea-movie-manager-rest-api/movies
PUT http://localhost/kea-movie-manager-rest-api/movies/27
DELETE http://localhost/kea-movie-manager-rest-api/movies/27

#### Sample Output:

```json
{
    "_total": 3,
    "data": [
        {"id": 24, "name": "Lord of the Rings: The Two Towers"},
        {"id": 1, "name": "Star Wars Episode IV: A New Hope"},
        {"id": 2, "name": "The Shape of Water"}
    ],
    "_links": [
        {
            "rel": "movies",
            "href": "<server_path>/kea-movie-manager-rest-api/movies{?name=}",
            "type": "GET"
        },
        {
            "rel": "movies",
            "href": "<server_path>/kea-movie-manager-rest-api/movies/{id}",
            "type": "GET"
        },
        {
            "rel": "movies",
            "href": "<server_path>/kea-movie-manager-rest-api/movies",
            "type": "POST"
        },
        {
            "rel": "movies",
            "href": "<server_path>/kea-movie-manager-rest-api/movies/{id}",
            "type": "PUT"
        },
        {
            "rel": "movies",
            "href": "<server_path>/kea-movie-manager-rest-api/movies{?name=}",
            "type": "DELETE"
        }
    ]
}
```

## Tools
PHP8 / MySQL

## Author:
Arturo Mora-Rioja (amri@kea.dk)