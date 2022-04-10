<?php

namespace App\Models;

use CodeIgniter\Model;

class ClientModel extends Model
{
    protected $table            = 'client';
    protected $allowedFields    = [
        'name', 'email', 'retainer_fee'
    ];

    // Dates
    protected $updatedField  = 'updated_at';


    public function findClientById($id)
    {
        $client = $this->asArray()->where(['id' => $id])->first();

        if(!$client) {
            throw new \Exception("Could not find client dor specified ID", 1);
        }

        return $client;
    }
}
