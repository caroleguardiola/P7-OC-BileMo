<?php
/**
 * Created by PhpStorm.
 * User: Carole Guardiola
 * Date: 05/05/2018
 * Time: 14:32
 */

namespace AppBundle\Representation;

use Pagerfanta\Pagerfanta;
use JMS\Serializer\Annotation\Type;

class Addresses
{
    /**
     * @Type("array<AppBundle\Entity\Address>")
     */
    public $data;

    public $meta;

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

    public function addMeta($name, $value)
    {
        if (isset($this->meta[$name])) {
            throw new \LogicException(sprintf('This meta already exists. You are trying to override this meta, use the setMeta method instead for the %s meta.', $name));
        }

        $this->setMeta($name, $value);
    }

    public function setMeta($name, $value)
    {
        $this->meta[$name] = $value;
    }
}