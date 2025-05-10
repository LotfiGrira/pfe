<?php

namespace App\Data;

class MirathInput
{
    public array $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function get(string $key, $default = null)
    {
        return $this->data[$key] ?? $default;
    }

    // Tu peux ajouter des méthodes spécifiques pour accéder à certaines valeurs plus facilement, par exemple :
    public function getGender()
    {
        return $this->get('gender');
    }

    public function getTarika()
    {
        return $this->get('tarika');
    }

    // Ajoute d'autres méthodes selon les besoins
}
