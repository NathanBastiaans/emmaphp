<?php

class DataObject implements ISystemComponentDataCompatible
{

	/**
	 * Assume a data structure much like an array does
	 * @param array $dataArray
	 */
    function __construct ($dataArray)
    {

        foreach ($dataArray as $data)
        {

            $key        = key ($dataArray);
            $this->$key = $data;
            next ($dataArray);

        }

    }

    public static function getInstance ($dataArray)
    {

        return new DataObject ($dataArray);

    }

}