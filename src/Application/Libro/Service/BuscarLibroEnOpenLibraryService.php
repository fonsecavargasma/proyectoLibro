<?php

namespace App\Application\Libro\Service;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use App\Application\Exceptions\OpenLibraryException;

class BuscarLibroEnOpenLibraryService
{
    private Client $httpClient;

    public function __construct()
    {
        $this->httpClient = new Client([
            'base_uri' => 'https://openlibrary.org/'
        ]);
    }

    public function buscarPorISBN(string $isbn): ?array
    {
        try {
            $response = $this->httpClient->get("api/books", [
                'query' => [
                    'bibkeys' => "ISBN:$isbn",
                    'format' => 'json',
                    'jscmd' => 'data'
                ]
            ]);

            $data = json_decode($response->getBody()->getContents(), true);
            if (isset($data["ISBN:$isbn"])) {
                $libroData = $data["ISBN:$isbn"];
                return [
                    'titulo' => $libroData['title'] ?? null,
                    'autor' => $libroData['authors'][0]['name'] ?? null,
                    'descripcion' => $libroData['description'] ?? null,
                    'portada' => $libroData['cover']['large'] ?? null,
                ];
            } else {

                throw new OpenLibraryException("No se encontró libro con ISBN: $isbn");
            }
        } catch (RequestException $e) {

            throw new OpenLibraryException("Error de conexión al buscar ISBN: $isbn. Detalles: " . $e->getMessage());
        } catch (\Exception $e) {

            throw new OpenLibraryException("Error inesperado al buscar ISBN: $isbn. Detalles: " . $e->getMessage());
        }

        return null;
    }

    public function buscarPorTituloOAutor(string $query): ?array
    {
        try {
            $response = $this->httpClient->get("search.json", [
                'query' => [
                    'q' => $query
                ]
            ]);

            $data = json_decode($response->getBody()->getContents(), true);
            if (!empty($data['docs'])) {
                $libroData = $data['docs'][0];
                return [
                    'titulo' => $libroData['title'] ?? null,
                    'autor' => $libroData['author_name'][0] ?? null,
                    'descripcion' => $libroData['first_sentence'] ?? null,
                    'portada' => isset($libroData['cover_i']) ? "https://covers.openlibrary.org/b/id/{$libroData['cover_i']}-L.jpg" : null,
                ];
            } else {

                throw new OpenLibraryException("No se encontraron libros para la búsqueda: $query");
            }
        } catch (RequestException $e) {

            throw new OpenLibraryException("Error de conexión al buscar por título o autor: $query. Detalles: " . $e->getMessage());
        } catch (\Exception $e) {

            throw new OpenLibraryException("Error inesperado al buscar por título o autor: $query. Detalles: " . $e->getMessage());
        }

        return null;
    }
}
