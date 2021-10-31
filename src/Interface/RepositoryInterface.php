<?php

declare(strict_types=1);

namespace App\Interface;

/**
 * RepositoryInterface
 *
 * @author <andy.rotsaert@live.be>
 */
interface RepositoryInterface
{
    /**
     * @param string $type
     * @return $this
     */
    public function getManager(string $type): self;

    /**
     * @param int|string $id
     * @return array|bool
     */
    public function find(int|string $id): array|bool;

    /**
     * @return array
     */
    public function get(): array;

    /**
     * @param array $criteria
     * @return array
     */
    public function findBy(array $criteria): array;
}
