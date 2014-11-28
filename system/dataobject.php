<?php

class DataObjectI implements ISystemComponentDataCompatible
{

    function __construct ($data_array)
    {

        foreach ($data_array as $data)
        {

            $key        = key ($data_array);
            $this->$key = $data;
            next ($data_array);

        }

    }

    public static function getInstance ($data_array)
    {

        return new DataObjectI ($data_array);

    }

}