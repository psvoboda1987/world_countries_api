<?php

class Country
{
    private $mysql;
    private $object_factory;

    public function __construct(
        ObjectFactory $object_factory
    )
    {
        $this->object_factory = $object_factory;

        $this->mysql = $this->object_factory->getObject(
            'Mysql',
            HOSTNAME, USERNAME, PASSWORD, DB
        );
    }

    public function getCountries()
    {
        $data = $this->getData();

        $list = $this->object_factory->getObject(
            'ListTemplate',
            'countries', $data
        );

        return $list->getHtml();
    }

    public function getCities()
    {
        $data = $this->getData();

        $list = $this->object_factory->getObject(
            'ListTemplate',
            'cities', $data
        );

        return $list->getHtml();
    }

    private function getData()
    {
        return $this->mysql->fetch("SELECT * FROM `country`");
    }
}