<?php
namespace App\FieldManagers;

use Lab123\Odin\FieldManager as BaseFieldManager;

class FieldManager extends BaseFieldManager
{

    public function store()
    {
        return $this->rules();
    }

    public function update()
    {
        return $this->rules();
    }

    /**
     * Adiciona sub campos para validação
     *
     * @param string $prefix            
     * @param array $fields            
     * @param array $mergeFields            
     *
     * @return array
     */
    protected function merge(string $prefix, array $fields, array $mergeFields)
    {
        foreach ($mergeFields as $key => $value) {
            $fields["{$prefix}.{$key}"] = $value;
        }
        
        return $fields;
    }
}