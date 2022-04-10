<?php

namespace App\Controllers;

use App\Models\ClientModel;
use CodeIgniter\HTTP\ResponseInterface;

class Clients extends BaseController
{
    /**
     * Return an array of resource objects, themselves in array format
     *
     * @return mixed
     */
    public function index()
    {
        $model = new ClientModel();
        return $this->getResponse([
            'message' => 'Clients retrieved successfully',
            'clients' => $model->findAll()
        ]);
    }

    /**
     * Return the properties of a resource object
     *
     * @return mixed
     */
    public function show($id = null)
    {
        try {

            $model = new ClientModel();
            $client = $model->findClientById($id);

            return $this->getResponse([
                'message' => 'Client retrieved successfully',
                'client' => $client
            ]);

        } catch (\Exception $e) {
            return $this->getResponse([
                'message' => 'Could not find client for specified ID'
            ], ResponseInterface::HTTP_NOT_FOUND);
        }
    }

    /**
     * Return a new resource object, with default properties
     *
     * @return mixed
     */
    public function new()
    {
        //
    }

    /**
     * Create a new resource object, from "posted" parameters
     *
     * @return mixed
     */
    public function create()
    {
        $rules = [
            'name' => 'required',
            'email' => 'required|min_length[6]|max_length[50]|valid_email|is_unique[client.email]',
            'retainer_fee' => 'required|max_length[255]'
        ];

        $input = $this->getRequestInput($this->request);

        if (!$this->validateRequest($input, $rules)) {
            return $this->getResponse($this->validator->getErrors(), ResponseInterface::HTTP_BAD_REQUEST);
        }

        $clientEmail = $input['email'];

        $model = new ClientModel();
        $model->save($input);


        $client = $model->where('email', $clientEmail)->first();

        return $this->getResponse([
            'message' => 'Client added successfully',
            'client' => $client
        ]);
    }

    /**
     * Return the editable properties of a resource object
     *
     * @return mixed
     */
    public function edit($id = null)
    {
        //
    }

    /**
     * Add or update a model resource, from "posted" properties
     *
     * @return mixed
     */
    public function update($id = null)
    {
        try {
            
            $model = new ClientModel();
            $model->findClientById($id);
            
            $input = $this->getRequestInput($this->request);
            
            //print_r($this->request);

            $model->update($id, $input);
            $client = $model->findClientById($id);

            return $this->getResponse([
                'message' => 'Client updated successfully',
                'client' => $client
            ]);

        } catch (\Exception $exception) {

            return $this->getResponse([
                'message' => $exception->getMessage()
            ], ResponseInterface::HTTP_NOT_FOUND);
        }
    }

    /**
     * Delete the designated resource object from the model
     *
     * @return mixed
     */
    public function delete($id = null)
    {
        try {

            $model = new ClientModel();
            $client = $model->findClientById($id);
            $model->delete($client);

            return $this->getResponse([
                'message' => 'Client deleted successfully',
            ], ResponseInterface::HTTP_NO_CONTENT);

        } catch (\Exception $exception) {
            return $this->getResponse([
                'message' => $exception->getMessage()
            ], ResponseInterface::HTTP_NOT_FOUND);
        }
    }
}
