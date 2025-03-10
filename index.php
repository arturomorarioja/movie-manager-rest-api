<?php
/**
 * KEA Movie Manager REST API
 * Refer to README.md for API documentation
 * 
 * @author  Arturo Mora-Rioja
 * @version 1.0.0 July 2020
 *          2.0.0 September 2021  HATEOAS links added
 *                                The API can now be served from any directory in the server
 *          2.0.1 December 2024   Refactoring
 * @version 2.0.2 March 2025      API utilities refactored to their own class 
*/

require_once 'classes/Movie.php';
require_once 'classes/Utils.php';

define('POS_ENTITY', 1);
define('POS_ID', 2);
define('ENTITY_MOVIES', 'movies');

$url = strtok($_SERVER['REQUEST_URI'], "?");    // GET parameters are removed
// If there is a trailing slash, it is removed, so that it is not taken into account by the explode function
if (substr($url, strlen($url) - 1) === '/') {
    $url = substr($url, 0, strlen($url) - 1);
}
// Everything up to the folder where this file exists is removed.
// This allows the API to be deployed to any directory in the server
$url = substr($url, strpos($url, basename(__DIR__)));

$urlPieces = explode('/', urldecode($url));

header('Content-Type: application/json');
header('Accept-version: v1');

http_response_code(200);
if (count($urlPieces) === 1) {       // (<current_dir>)
    echo Utils::APIDescription();
} else {
    if (($urlPieces[POS_ENTITY] !== ENTITY_MOVIES) || (count($urlPieces) > 3)) {
        http_response_code(400);
        echo Utils::formatError();
    } else {
        $movie = new Movie();

        $verb = $_SERVER['REQUEST_METHOD'];
        switch ($verb) {
            case 'GET':
                if (count($urlPieces) === 3) {                      // Get movie by id (<current_dir>/movies/{id})
                    $results = $movie->get($urlPieces[POS_ID]);
                } elseif (isset($_GET['s'])) {                      // Search movie by name
                    $results = $movie->search($_GET['s']);
                } else {                                            // Get all movies
                    $results = $movie->list();
                }
                if (isset($results['error'])) { http_response_code(500); }
                echo Utils::addHATEOAS($results, ENTITY_MOVIES);
                break;
            case 'POST':                                            // Add movie
                if (isset($_POST['name'])) {                        
                    $results = $movie->add(trim($_POST['name']));
                    if (isset($results['error'])) { http_response_code(500); }
                    echo Utils::addHATEOAS($results, ENTITY_MOVIES);
                } else {
                    http_response_code(400);
                    echo Utils::formatError();
                }
                break;
            case 'PUT':                                             // Update movie
                // Since PHP does not handle PUT parameters explicitly,
                // they must be read from the request body's raw data
                $movieData = (array) json_decode(file_get_contents('php://input'), TRUE); 
                if ((count($urlPieces) === 3) && (isset($movieData['name']))) {  // (<current_dir>/movies/{id})
                    $results = $movie->update($urlPieces[POS_ID], trim($movieData['name']));
                    if (isset($results['error'])) { http_response_code(500); }
                    echo Utils::addHATEOAS($results, ENTITY_MOVIES);
                } else {
                    http_response_code(400);
                    echo Utils::formatError();
                }
                break;
            case 'DELETE':                                          // Delete movie
                if (count($urlPieces) === 3) {                      // (<current_dir>/movies/{id})
                    $results = $movie->delete($urlPieces[POS_ID]);
                    if (isset($results['error'])) { http_response_code(500); }
                    echo Utils::addHATEOAS($results, ENTITY_MOVIES);
                } else {
                    http_response_code(400);
                    echo Utils::formatError();
                }
                break;
            default:
                http_response_code(405);
                echo Utils::formatError();
        }
        $movie = null;
    }
}