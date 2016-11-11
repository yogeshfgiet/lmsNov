<?php namespace App\Models;

class DtQuery {

    /*
      |--------------------------------------------------------------------------
      | DtQuery Model
      |--------------------------------------------------------------------------
      |
      | This Model will create the query for datatables
      | It will also fetch the data after the final datatable query
      | It will also arrange the data in proper order so it will work with datatable
      |
     */

    /**
     * Method that will return the limit of the query
     *
     * @param object $query Query Builder object
     * @param array $dtParams datatable request parameters
     * @return object query builder object
     */
    public function setLimit($query, $dtParams)
    {
        $query = $query->skip($dtParams['start'])
            ->take($dtParams['length']);

        return $query;
    }

    /**
     * Method that will set order of the query
     *
     * @param object $query Query Builder object
     * @param array $dtParams datatable request parameters
     * @param array $allFields All fields that are on datatables in array
     * @param array $defaultSort array list of sorting columns with direction
     *
     * @return object query builder object
     */
    public function setOrders($query, $dtParams, $allFields, $defaultSort =
    array())
    {
        $orderList = isset($dtParams['order']) ? $dtParams['order'] : null;

        //If order is set
        if ((isset($orderList)) && (!empty($orderList)))
        {
            foreach ($orderList as $eachOrder)
            {
                $sortedCol = $eachOrder['column'];

                $usedFieldName = $dtParams['columns'][$sortedCol]['data'];
                $dbCol = $allFields[$usedFieldName];

                $query->orderBy($dbCol, $eachOrder['dir']);
            }
        } elseif ((isset($defaultSort)) && (!empty($defaultSort))) {
            foreach($defaultSort as $col => $dir) {
                $query->orderBy($col, $dir);
            }
        }

        return $query;
    }

    /**
     * Method that will set where conditions to the query
     *
     * @param object $query Query Builder object
     * @param array $dtParams datatable request parameters
     * @param array $allFields All fields that are on datatables in array
     * @return object query builder object
     */
    public function setWhere($query, $dtParams, $allFields)
    {
        $searchVal = $dtParams['search']['value'];
        $sWhere = '';

        //It will add where condition for those which are
        if (!empty($searchVal))
        {
            $searchData = $searchVal . '%';
            $searchDataArray = array();

            foreach ($dtParams['columns'] as $key => $eachCol)
            {
                if ('true' === $eachCol['searchable'])
                {
                    $usedFieldName = $dtParams['columns'][$key]['data'];
                    $dbCol = $allFields[$usedFieldName];

                    $sWhere .= $dbCol . ' LIKE ? OR ';
                    $searchDataArray[] = $searchData;
                }
            }

            $query->whereRaw(rtrim($sWhere, ' OR'), $searchDataArray);
        }
        return $query;
    }

    /**
     * Method that will prepare response as required to datatable
     *
     * @param array $currentRecords details of current records
     * @param array $totalNoOfRecords details of total number of possible records without limit
     * @param array $dtParams datatable request parameters
     * @return array dtResponse in required format
     */
    public function prepareDtResponse($currentRecords, $totalNoOfRecords,
        $dtParams)
    {
        $currentRecords = json_decode(json_encode($currentRecords), true);
        $totalNoOfRecords = json_decode(json_encode($totalNoOfRecords), true);

        //Initializing the output
        $output = array(
            "draw" => intval($dtParams['draw']),
            "recordsTotal" => 0,
            "recordsFiltered" => 0,
            "data" => array(),
        );

        //If getting any data
        if (isset($currentRecords) && (!empty($currentRecords)))
        {
            $currentRowsCount = count($currentRecords);

            // If results then count and sort else return empty
            if ($currentRowsCount > 0)
            {
                $totalDisplayRecordsCount = $totalNoOfRecords[0]['total_records'];

                //Final Output array
                $output = array(
                    "draw" => intval($dtParams['draw']),
                    "recordsTotal" => $totalDisplayRecordsCount,
                    "recordsFiltered" => $totalDisplayRecordsCount,
                    "data" => array()
                );
                //initializing an array for output
                $aaData = array();

                //Put all the data in a array to print outside
                foreach ($currentRecords as $rowData)
                {
                    $row = array();

                    //Put each records of the row
                    foreach ($rowData as $key => $colData)
                    {
                        //Formating the records
                        $row[$key] = htmlentities($colData);
                    }
                    //Put the data in the output array
                    $aaData[] = $row;
                }
                //add the output data in the array list
                $output['data'] = $aaData;
            }
        }

        return $output;
    }

}
