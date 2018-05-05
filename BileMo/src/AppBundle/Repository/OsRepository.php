<?php

namespace AppBundle\Repository;

/**
 * OsRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class OsRepository extends AbstractRepository
{
    public function search($order = 'asc', $limit = 20, $offset = 0)
    {
        $qb = $this
            ->createQueryBuilder('o')
            ->select('o')
            ->orderBy('o.name', $order);

        return $this->paginate($qb, $limit, $offset);
    }
}

