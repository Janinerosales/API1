<?php

interface user
{
    public function createTable();
    public function search($params);
    public function getAll();
    public function create($params);
    public function update($params);
    public function delete($params);
}