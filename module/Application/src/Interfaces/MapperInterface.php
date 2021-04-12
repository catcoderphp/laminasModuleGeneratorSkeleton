<?php

namespace Application\Interfaces;

interface MapperInterface
{
    public function create($data);

    public function get($id);

    public function getList();

    public function update($id, $data);

    public function delete($id);
}