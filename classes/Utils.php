<?php

Class Utils
{
    private const ENTITY_MOVIES = 'movies';

    /**
     * Returns the REST API description
     */
    public static function APIDescription(): string 
    {
        return self::addHATEOAS();
    }

    /**
     * Adds HATEOAS links to the data it receives as a parameter
     * 
     * @param  $information    Entity information to add the HATEOAS links to
     * @param  $entity         Name of the entity the HATEOAS links will be added to.
     *                          If false, only the HATEOAS links will be returned
     * @return string The information to be served by the API including its corresponding HATEOAS links
     */
    public static function addHATEOAS(array $information = [], string $entity = ''): string 
    {
        $curDir = self::urlPath();

        if ($entity) {
            $apiInfo[$entity] = $information;
        }
        $apiInfo['_links'] = array(
            array(
                'rel' => ($entity === self::ENTITY_MOVIES ? 'self' : self::ENTITY_MOVIES),
                'href' => $curDir . self::ENTITY_MOVIES . '{?s=}',
                'type' => 'GET'
            ),
            array(
                'rel' => ($entity === self::ENTITY_MOVIES ? 'self' : self::ENTITY_MOVIES),
                'href' => $curDir . self::ENTITY_MOVIES . '/{id}',
                'type' => 'GET'
            ),
            array(
                'rel' => ($entity === self::ENTITY_MOVIES ? 'self' : self::ENTITY_MOVIES),
                'href' => $curDir . self::ENTITY_MOVIES,
                'type' => 'POST'
            ),
            array(
                'rel' => ($entity === self::ENTITY_MOVIES ? 'self' : self::ENTITY_MOVIES),
                'href' => $curDir . self::ENTITY_MOVIES . '/{id}',
                'type' => 'PUT'
            ),
            array(
                'rel' => ($entity === self::ENTITY_MOVIES ? 'self' : self::ENTITY_MOVIES),
                'href' => $curDir . self::ENTITY_MOVIES . '/{id}',
                'type' => 'DELETE'
            )
        );        
        return json_encode($apiInfo);
    }

    /**
     * Returns a format error
     */
    public static function formatError(): string 
    {
        $output['message'] = 'Incorrect format';
        return self::addHATEOAS($output, '_error');
    }    

    /**
     * Returns the API's URL path
     */
    private static function urlPath(): string 
    {
        $protocol = ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') || $_SERVER['SERVER_PORT'] == 443) ? 'https://' : 'http://';
        return $protocol . $_SERVER['HTTP_HOST'] . '/' . basename(__DIR__) . '/';     
    }    
}