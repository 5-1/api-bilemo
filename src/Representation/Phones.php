<?php

namespace App\Representation;

use JMS\Serializer\Annotation as Serializer;

use Pagerfanta\Pagerfanta;
use JMS\Serializer\Annotation\Type;
class Phones
{
    /**
     * @Type("array<App\Entity\Phone>")

     * @Serializer\Groups({"list"})
     */
    public $data;
    /**
     * @Serializer\Groups({"list"})
     *
     */

    public $meta;

    public function __construct(Pagerfanta $data)
    {
        $this->data = $data->getCurrentPageResults();


        $this->addmeta('limit', $data->getMaxPerPage());
        $this->addMeta('current_items', count($data->getCurrentPageResults()));
        $this->addMeta('total_items', $data->getNbResults());
        $this->addMeta('page', $data->getCurrentPage());

    }
    public function addMeta($name, $value)
    {
        if (isset($this->meta[$name])) {
            throw new \LogicException(sprintf('This meta already exists. 
            You are trying to override this meta, use setMeta method instead for %s meta.', $name));
        }
        $this->setMeta($name, $value);
    }
    public function setMeta($name, $value)
    {
        $this->meta[$name] = $value;

    }
}