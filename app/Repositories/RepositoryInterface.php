<?php

namespace App\Repositories;

/**
 * Interface RepositoryInterface
 *
 * @package App\Repositories
 */
interface RepositoryInterface
{
    /**
     * @param  array  $attributes
     * 
     * @return mixed
     */
    public function save(array $attributes);

    /**
     * @param  array  $attributes
     *
     * @return mixed
     */
    public function create(array $attributes);

    /**
     * @return mixed
     */
    public function query();

    /**
     * @param  int $id
     *
     * @return mixed
     */
    public function getById(int $id);

    /**
     * @param  array  $first
     * @param  array  $create
     *
     * @return mixed
     */
    public function firstOrCreate(array $first , array $create);

    /**
     * @param  string $uuid
     *
     * @return mixed
     */
    public function getByUuid(string $uuid);
}