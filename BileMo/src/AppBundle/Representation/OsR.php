<?php
/**
 * Created by PhpStorm.
 * User: Carole Guardiola
 * Date: 05/05/2018
 * Time: 15:25
 */

/*
 * This file is part of the Symfony package.
 *
 * (c) Carole Guardiola <carole.guardiola@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\Representation;

use Pagerfanta\Pagerfanta;
use JMS\Serializer\Annotation\Type;

class OsR
{
    /**
     * @Type("array<AppBundle\Entity\Os>")
     */
    public $data;

    public $meta;

    /**
     * OsR constructor.
     *
     * @param Pagerfanta $data
     */
    public function __construct(Pagerfanta $data)
    {
        $this->data = $data->getCurrentPageResults();

        $this->addMeta('limit', $data->getMaxPerPage());
        $this->addMeta('current_items', count($data->getCurrentPageResults()));
        $this->addMeta('total_items', $data->getNbResults());
        $this->addMeta('offset', $data->getCurrentPageOffsetStart());
        $this->addMeta('current_page', $data->getCurrentPage());
        $this->addMeta('offset_end', $data->getCurrentPageOffsetEnd());
        $this->addMeta('nb_page', $data->getNbPages());

        if($data->hasNextPage()) {
            $this->addMeta('next_page', $data->getNextPage());
        }

        if($data->hasPreviousPage()) {
            $this->addMeta('previous_page', $data->getPreviousPage());
        }
    }

    /**
     * @param $name
     * @param $value
     */
    public function addMeta($name, $value)
    {
        if (isset($this->meta[$name])) {
            throw new \LogicException(sprintf('This meta already exists. You are trying to override this meta, use the setMeta method instead for the %s meta.', $name));
        }

        $this->setMeta($name, $value);
    }

    /**
     * @param $name
     * @param $value
     */
    public function setMeta($name, $value)
    {
        $this->meta[$name] = $value;
    }
}