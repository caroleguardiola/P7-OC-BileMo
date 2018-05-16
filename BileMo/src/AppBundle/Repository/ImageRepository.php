<?php

namespace AppBundle\Repository;

/**
 * ImageRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ImageRepository extends AbstractRepository
{
    public function search($order = 'asc', $limit = 20, $offset = 0)
    {
        $query = $this
            ->createQueryBuilder('i')
            ->select('i')
            ->orderBy('i.alt', $order);

        return $this->paginate($query, $limit, $offset);
    }
}
